<?php
$cid = current_company_id();
$today = date('Y-m-d');
$co = current_company();

/* ---- Non conformità aperte per gravità ---- */
$ncOpen = all_rows("SELECT severity, COUNT(*) c FROM non_conformities WHERE company_id=? AND status!='chiusa' GROUP BY severity", [$cid]);
$ncBySev = ['critica'=>0,'alta'=>0,'media'=>0,'bassa'=>0];
foreach ($ncOpen as $r) $ncBySev[$r['severity']] = (int)$r['c'];
$ncOpenTotal = array_sum($ncBySev);

/* ---- Strumenti ---- */
$instr = all_rows("SELECT status, COUNT(*) c FROM instruments WHERE company_id=? GROUP BY status", [$cid]);
$instrBy = ['idoneo'=>0,'in_scadenza'=>0,'scaduto'=>0,'fuori_uso'=>0];
foreach ($instr as $r) $instrBy[$r['status']] = (int)$r['c'];

/* ---- Attività scadute / in arrivo ---- */
$overdue = (int)(one("SELECT COUNT(*) c FROM activities WHERE company_id=? AND status NOT IN ('completata','annullata') AND due_date < ?", [$cid, $today])['c'] ?? 0);
$next14 = (int)(one("SELECT COUNT(*) c FROM activities WHERE company_id=? AND status NOT IN ('completata','annullata') AND due_date >= ? AND due_date <= date(?, '+14 day')", [$cid, $today, $today])['c'] ?? 0);

/* ---- Audit ---- */
$auditPlanned = (int)(one("SELECT COUNT(*) c FROM audits WHERE company_id=? AND status IN ('pianificato','in_corso','rilievi','follow_up')", [$cid])['c'] ?? 0);
$findOpen = all_rows("SELECT type, COUNT(*) c FROM audit_findings WHERE company_id=? AND status!='chiuso' GROUP BY type", [$cid]);
$findBy = [];
foreach ($findOpen as $r) $findBy[$r['type']] = (int)$r['c'];

/* ---- Documenti scaduti ---- */
$docExpired = (int)(one("SELECT COUNT(*) c FROM documents WHERE company_id=? AND (status='scaduto' OR (expiry_date IS NOT NULL AND expiry_date < ?))", [$cid, $today])['c'] ?? 0);

/* ---- INDICE DI PRONTEZZA AUDIT (signature) ---- */
$readiness = 100;
$readiness -= $ncBySev['critica']*8 + $ncBySev['alta']*5 + $ncBySev['media']*3 + $ncBySev['bassa']*1;
$readiness -= $instrBy['scaduto']*4 + $instrBy['in_scadenza']*2;
$readiness -= $overdue*3;
$readiness -= ($findBy['nc_maggiore'] ?? 0)*4 + ($findBy['nc_minore'] ?? 0)*2;
$readiness -= $docExpired*2;
$readiness = max(8, min(100, $readiness));
$rTone = $readiness >= 85 ? 'success' : ($readiness >= 65 ? 'warning' : 'danger');
$rLabel = $readiness >= 85 ? 'Pronti' : ($readiness >= 65 ? 'Da consolidare' : 'Attenzione');

/* ---- Scadenze unificate ---- */
$deadlines = [];
foreach (all_rows("SELECT id, title, due_date, type, status FROM activities WHERE company_id=? AND status NOT IN ('completata','annullata') AND due_date IS NOT NULL", [$cid]) as $a) {
    $deadlines[] = ['date'=>$a['due_date'], 'title'=>$a['title'], 'kind'=>activity_type_label($a['type']), 'icon'=>'calendar', 'link'=>'index.php?page=calendar'];
}
foreach (all_rows("SELECT id, code, name, next_calibration FROM instruments WHERE company_id=? AND next_calibration IS NOT NULL AND status!='idoneo'", [$cid]) as $i) {
    $deadlines[] = ['date'=>$i['next_calibration'], 'title'=>"Taratura {$i['code']} · {$i['name']}", 'kind'=>'Taratura', 'icon'=>'wrench', 'link'=>'index.php?page=machines'];
}
foreach (all_rows("SELECT id, code, title, review_date FROM documents WHERE company_id=? AND review_date IS NOT NULL AND review_date <= date(?, '+30 day')", [$cid, $today]) as $d) {
    $deadlines[] = ['date'=>$d['review_date'], 'title'=>"Revisione {$d['code']} · {$d['title']}", 'kind'=>'Documento', 'icon'=>'document', 'link'=>'index.php?page=documents'];
}
usort($deadlines, fn($a,$b) => strcmp($a['date'],$b['date']));
$deadlines = array_slice($deadlines, 0, 7);

/* ---- KPI di processo con sparkline ---- */
function indicator_series(int $id): array {
    $rows = all_rows("SELECT period_label, value FROM indicator_measurements WHERE indicator_id=? ORDER BY id", [$id]);
    return $rows;
}
$kpiProcs = all_rows("SELECT * FROM process_indicators WHERE company_id=? AND id IN (1,3,2,6) ORDER BY CASE id WHEN 1 THEN 1 WHEN 3 THEN 2 WHEN 2 THEN 3 ELSE 4 END", [$cid]);

/* ---- Sparkline per KPI tiles (NC trend ultimi mesi - usiamo PPM cliente) ---- */
$ppmSeries = array_map(fn($r)=>(float)$r['value'], indicator_series(3));

/* ---- Log recenti ---- */
$logs = all_rows("SELECT al.*, u.name uname FROM activity_logs al LEFT JOIN users u ON u.id=al.user_id WHERE al.company_id=? ORDER BY al.created_at DESC LIMIT 6", [$cid]);

$daysToAudit = days_until($co['next_audit_date'] ?? null);

layout_start('Cruscotto qualità', 'dashboard', $co['name'] ?? '');
?>

<section class="hero">
  <div class="hero-gauge card">
    <div class="hero-gauge-ring">
      <?= ring($readiness, 168, 16, $rTone, count_up($readiness, '', 0), 'su 100') ?>
    </div>
    <div class="hero-gauge-meta">
      <span class="eyebrow"><?= icon('gauge', 16) ?> Indice di prontezza audit</span>
      <h2><?= badge($rLabel, $rTone, 'dot') ?></h2>
      <p>Stima sintetica dello stato del sistema qualità rispetto a un audit. Considera non conformità aperte, tarature, scadenze e rilievi.</p>
      <div class="hero-gauge-facts">
        <div><strong><?= $daysToAudit !== null ? max(0,$daysToAudit) : '—' ?></strong><small>gg al prossimo audit ente</small></div>
        <div><strong><?= e($co['standards'] ?? '') ?></strong><small>standard certificati</small></div>
      </div>
    </div>
  </div>

  <div class="hero-kpis">
    <?php
      kpi_tile('NC aperte', $ncOpenTotal, $ncBySev['critica']+$ncBySev['alta'] . ' ad alta priorità', $ncOpenTotal? 'danger':'success', 'nc');
      kpi_tile('Audit in corso', $auditPlanned, 'pianificati o da chiudere', $auditPlanned? 'warning':'success', 'audit');
      kpi_tile('Scadenze 14 gg', $next14, $overdue . ' già in ritardo', $overdue? 'danger':($next14?'warning':'success'), 'clock');
      kpi_tile('Strumenti da tarare', $instrBy['scaduto']+$instrBy['in_scadenza'], $instrBy['scaduto'] . ' scaduti', ($instrBy['scaduto']?'danger':($instrBy['in_scadenza']?'warning':'success')), 'wrench');
    ?>
  </div>
</section>

<section class="grid-2">
  <div class="card">
    <?php section_title('Prossime scadenze', 'Attività, tarature e revisioni in arrivo', '<a class="btn btn-ghost btn-sm" href="index.php?page=calendar">Scadenzario</a>'); ?>
    <?php if (!$deadlines): ?>
      <?php empty_state('Nessuna scadenza imminente. Ottimo lavoro.', 'check'); ?>
    <?php else: ?>
      <ul class="timeline">
        <?php foreach ($deadlines as $d): $tone = due_tone($d['date']); ?>
          <li class="tl-item">
            <span class="tl-ic tone-<?= $tone ?>"><?= icon($d['icon'], 16) ?></span>
            <div class="tl-body">
              <a href="<?= e($d['link']) ?>" class="tl-title"><?= e($d['title']) ?></a>
              <span class="tl-meta"><?= e($d['kind']) ?> · <?= date_it($d['date']) ?></span>
            </div>
            <?= badge(due_label($d['date']), $tone) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

  <div class="card">
    <?php section_title('Non conformità aperte', 'Distribuzione per gravità', '<a class="btn btn-ghost btn-sm" href="index.php?page=nc">Gestisci</a>'); ?>
    <div class="donut-row">
      <?= donut([
        ['value'=>$ncBySev['critica'],'tone'=>'danger','label'=>'Critica'],
        ['value'=>$ncBySev['alta'],'tone'=>'warning','label'=>'Alta'],
        ['value'=>$ncBySev['media'],'tone'=>'primary','label'=>'Media'],
        ['value'=>$ncBySev['bassa'],'tone'=>'muted','label'=>'Bassa'],
      ], 150, 18, (string)$ncOpenTotal, 'aperte') ?>
      <?= legend([
        ['tone'=>'danger','label'=>'Critica','value'=>$ncBySev['critica']],
        ['tone'=>'warning','label'=>'Alta','value'=>$ncBySev['alta']],
        ['tone'=>'primary','label'=>'Media','value'=>$ncBySev['media']],
        ['tone'=>'muted','label'=>'Bassa','value'=>$ncBySev['bassa']],
      ]) ?>
    </div>
    <div class="mini-facts">
      <div><span class="mf-k"><?= ($findBy['nc_maggiore'] ?? 0)+($findBy['nc_minore'] ?? 0) ?></span><span class="mf-l">rilievi audit aperti</span></div>
      <div><span class="mf-k"><?= $docExpired ?></span><span class="mf-l">documenti scaduti</span></div>
    </div>
  </div>
</section>

<section class="card">
  <?php section_title('Indicatori di processo', 'Andamento ultimi mesi rispetto al target', '<a class="btn btn-ghost btn-sm" href="index.php?page=processes">Processi</a>'); ?>
  <div class="kpi-proc-grid">
    <?php foreach ($kpiProcs as $ind):
      $series = indicator_series((int)$ind['id']);
      $vals = array_map(fn($r)=>(float)$r['value'], $series);
      $last = end($vals) ?: 0;
      $ok = $ind['direction']==='max' ? $last >= $ind['target'] : $last <= $ind['target'];
      $tone = $ok ? 'success' : 'warning';
    ?>
      <div class="kpi-proc">
        <div class="kpi-proc-head">
          <span class="kpi-proc-name"><?= e($ind['name']) ?></span>
          <?= badge(($ok?'in target':'sotto target'), $tone, 'dot') ?>
        </div>
        <div class="kpi-proc-val"><?= count_up($last, ' '.$ind['unit'], 0) ?><small>target <?= ($ind['direction']==='max'?'≥':'≤') ?> <?= it_num($ind['target']) ?> <?= e($ind['unit']) ?></small></div>
        <?= sparkline($vals, $tone, 200, 44) ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="grid-2">
  <div class="card">
    <?php section_title('Attività recenti', 'Ultime operazioni registrate'); ?>
    <ul class="feed">
      <?php foreach ($logs as $l): ?>
        <li><span class="feed-dot"></span><div><p><?= e($l['description']) ?></p><small><?= e($l['uname'] ?? 'Sistema') ?> · <?= datetime_it($l['created_at']) ?></small></div></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="card card-cta">
    <?php section_title('Azioni rapide', 'Avvia le attività più frequenti'); ?>
    <div class="quick-grid">
      <a class="quick" href="index.php?page=nc"><?= icon('nc',20) ?><span>Apri non conformità</span></a>
      <a class="quick" href="index.php?page=audits"><?= icon('audit',20) ?><span>Pianifica audit</span></a>
      <a class="quick" href="index.php?page=checklists"><?= icon('checklist',20) ?><span>Avvia checklist</span></a>
      <a class="quick" href="index.php?page=calendar"><?= icon('calendar',20) ?><span>Nuova scadenza</span></a>
    </div>
  </div>
</section>

<?php layout_end(); ?>
