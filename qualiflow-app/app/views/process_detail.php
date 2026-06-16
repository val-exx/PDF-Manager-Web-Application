<?php
$cid = current_company_id();
$id = (int)($_GET['id'] ?? 0);
$p = one("SELECT p.*, u.name owner_name FROM processes p LEFT JOIN users u ON u.id=p.owner_id WHERE p.id=? AND p.company_id=?", [$id, $cid]);
if (!$p) { layout_start('Processi', 'processes'); empty_state('Processo non trovato.', 'process'); layout_end(); return; }

$indicators = all_rows("SELECT * FROM process_indicators WHERE process_id=? ORDER BY id", [$id]);
$risks = all_rows("SELECT r.*, u.name owner_name FROM process_risks r LEFT JOIN users u ON u.id=r.owner_id WHERE r.process_id=? ORDER BY (r.probability*r.impact) DESC", [$id]);
$docs = all_rows("SELECT * FROM documents WHERE process_id=? ORDER BY code", [$id]);

layout_start('Processo ' . $p['code'], 'processes', $p['name']);
?>
<a class="back-lnk" href="index.php?page=processes"><?= icon('chevron',14) ?> Mappa dei processi</a>

<div class="card">
  <div class="detail-head">
    <div><span class="mono badge badge-neutral"><?= e($p['code']) ?></span><?= badge(process_type_label($p['type']),'info') ?><?= badge(ucfirst($p['status']), $p['status']==='attivo'?'success':'warning','dot') ?></div>
  </div>
  <h2 class="detail-title"><?= e($p['name']) ?></h2>
  <?php if ($p['purpose']): ?><p class="detail-note"><?= e($p['purpose']) ?></p><?php endif; ?>
  <div class="io-flow">
    <div class="io-box"><span class="io-label">Input</span><p><?= e($p['inputs'] ?: '—') ?></p></div>
    <span class="io-arrow"><?= icon('chevron',22) ?></span>
    <div class="io-box io-proc"><span class="io-label">Processo</span><p><?= e($p['name']) ?></p><small><?= icon('people',13) ?> <?= e($p['owner_name'] ?: '—') ?></small></div>
    <span class="io-arrow"><?= icon('chevron',22) ?></span>
    <div class="io-box"><span class="io-label">Output</span><p><?= e($p['outputs'] ?: '—') ?></p></div>
  </div>
</div>

<div class="card">
  <?php section_title('Indicatori (KPI)', 'Andamento e target'); ?>
  <?php if (!$indicators): ?>
    <?php empty_state('Nessun indicatore per questo processo.', 'gauge'); ?>
  <?php else: ?>
    <div class="ind-grid">
      <?php foreach ($indicators as $ind):
        $meas = all_rows("SELECT period_label, value FROM indicator_measurements WHERE indicator_id=? ORDER BY id", [$ind['id']]);
        $data = array_map(fn($m)=>['label'=>$m['period_label'],'value'=>(float)$m['value'],'tone'=>($ind['direction']==='max'? ((float)$m['value']>=$ind['target']?'success':'warning') : ((float)$m['value']<=$ind['target']?'success':'danger'))], $meas);
        $last = $meas ? (float)end($meas)['value'] : 0;
        $ok = $ind['direction']==='max' ? $last>=$ind['target'] : $last<=$ind['target'];
      ?>
        <div class="ind-card">
          <div class="ind-head">
            <div><strong><?= e($ind['name']) ?></strong><small class="muted">target <?= $ind['direction']==='max'?'≥':'≤' ?> <?= it_num($ind['target']) ?> <?= e($ind['unit']) ?></small></div>
            <span class="ind-last tone-<?= $ok?'success':'warning' ?>"><?= it_num($last) ?> <?= e($ind['unit']) ?></span>
          </div>
          <?= bars($data, (float)$ind['target'], ' '.$ind['unit']) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php if (user_can_write() && $indicators): ?>
    <?= add_panel_open('Registra misurazione', 'save_indicator_measurement') ?>
    <input type="hidden" name="process_id" value="<?= $id ?>">
    <div class="form-grid">
      <?php $iOpts=''; foreach($indicators as $ind) $iOpts.='<option value="'.$ind['id'].'">'.e($ind['name']).'</option>'; ?>
      <label class="field"><span>Indicatore</span><select class="input" name="indicator_id"><?= $iOpts ?></select></label>
      <?= field_input('period_label','Periodo','','text','Es. Lug') ?>
      <?= field_input('value','Valore','','number') ?>
      <?= field_date('measured_at','Data') ?>
    </div>
    <?= add_panel_close('Registra') ?>
  <?php endif; ?>
</div>

<div class="card">
  <?php section_title('Rischi e opportunità', 'Valutazione P×I (1–5)'); ?>
  <?php if (!$risks): ?>
    <?php empty_state('Nessun rischio o opportunità registrato.', 'alert'); ?>
  <?php else: ?>
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Tipo</th><th>Descrizione</th><th>P×I</th><th>Livello</th><th>Presidio</th><th>Stato</th></tr></thead>
        <tbody>
        <?php foreach ($risks as $r): $rpn=(int)$r['probability']*(int)$r['impact']; $lvl=$rpn>=15?'danger':($rpn>=8?'warning':'success'); $lblLvl=$rpn>=15?'Alto':($rpn>=8?'Medio':'Basso'); ?>
          <tr>
            <td><?= $r['type']==='opportunita'?badge('Opportunità','info'):badge('Rischio','neutral') ?></td>
            <td><?= e($r['description']) ?></td>
            <td><span class="mono"><?= (int)$r['probability'] ?>×<?= (int)$r['impact'] ?></span></td>
            <td><?= badge($lblLvl.' ('.$rpn.')', $lvl, 'dot') ?></td>
            <td><?= e($r['mitigation'] ?: '—') ?></td>
            <td><?= badge(ucfirst($r['status']), $r['status']==='chiuso'?'success':($r['status']==='presidiato'?'warning':'danger')) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
  <?php if (user_can_write()): ?>
    <?= add_panel_open('Aggiungi rischio / opportunità', 'save_process_risk') ?>
    <input type="hidden" name="process_id" value="<?= $id ?>">
    <div class="form-grid">
      <?= field_select('type','Tipo', ['rischio'=>'Rischio','opportunita'=>'Opportunità'], 'rischio') ?>
      <?= field_select('probability','Probabilità (1-5)', [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'], 2) ?>
      <?= field_select('impact','Impatto (1-5)', [1=>'1',2=>'2',3=>'3',4=>'4',5=>'5'], 2) ?>
      <label class="field"><span>Responsabile</span><select class="input" name="owner_id"><?= users_options() ?></select></label>
    </div>
    <?= field_textarea('description','Descrizione','','Descrizione del rischio/opportunità') ?>
    <?= field_input('mitigation','Presidio / azione','','text','Come viene gestito') ?>
    <?= add_panel_close('Aggiungi') ?>
  <?php endif; ?>
</div>

<?php if ($docs): ?>
<div class="card">
  <?php section_title('Documenti collegati', count($docs).' documenti'); ?>
  <ul class="link-list">
    <?php foreach ($docs as $d): ?>
      <li><a href="index.php?page=documents"><span class="mono"><?= e($d['code']) ?></span> <?= e($d['title']) ?></a><?= badge(doc_status_label($d['status']), doc_status_tone($d['status'])) ?></li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>
<?php layout_end(); ?>
