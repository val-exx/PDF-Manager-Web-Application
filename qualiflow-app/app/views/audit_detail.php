<?php
$cid = current_company_id();
$id = (int)($_GET['id'] ?? 0);
$a = one("SELECT a.*, p.name partner_name, u.name auditor_name, pr.code proc_code, pr.name proc_name, t.name tpl_name
          FROM audits a
          LEFT JOIN partners p ON p.id=a.partner_id
          LEFT JOIN users u ON u.id=a.lead_auditor_id
          LEFT JOIN processes pr ON pr.id=a.process_id
          LEFT JOIN checklist_templates t ON t.id=a.template_id
          WHERE a.id=? AND a.company_id=?", [$id, $cid]);
if (!$a) { layout_start('Audit', 'audits'); empty_state('Audit non trovato.', 'audit'); layout_end(); return; }

$findings = all_rows("SELECT f.*, u.name owner_name FROM audit_findings f LEFT JOIN users u ON u.id=f.owner_id WHERE f.audit_id=? ORDER BY f.id", [$id]);
$runs = all_rows("SELECT * FROM checklist_runs WHERE audit_id=? ORDER BY id DESC", [$id]);

$flow = ['pianificato','in_corso','rilievi','follow_up','chiuso'];
$curIdx = array_search($a['status'], $flow, true);
$steps = [];
$labels = ['pianificato'=>'Pianificato','in_corso'=>'In corso','rilievi'=>'Rilievi','follow_up'=>'Follow-up','chiuso'=>'Chiuso'];
foreach ($flow as $i => $s) {
    $steps[] = ['label'=>$labels[$s], 'done'=>$i < $curIdx, 'current'=>$i===$curIdx, 'n'=>$i+1];
}

layout_start('Audit ' . $a['code'], 'audits', $a['title']);
?>
<a class="back-lnk" href="index.php?page=audits"><?= icon('chevron',14) ?> Tutti gli audit</a>

<div class="card">
  <div class="detail-head">
    <div>
      <span class="mono badge badge-neutral"><?= e($a['code']) ?></span>
      <?= badge(audit_type_label($a['audit_type']), 'info') ?>
      <?= badge(audit_status_label($a['status']), audit_status_tone($a['status']), 'dot') ?>
    </div>
    <?php if ($a['score']!==null): ?><div class="score-big"><strong><?= (int)$a['score'] ?></strong><small>punteggio</small></div><?php endif; ?>
  </div>
  <h2 class="detail-title"><?= e($a['title']) ?></h2>
  <?= stepper($steps) ?>
  <div class="detail-grid">
    <div><span class="dl">Norma</span><span class="dv"><?= e($a['standard'] ?: '—') ?></span></div>
    <div><span class="dl">Lead auditor</span><span class="dv"><?= e($a['auditor_name'] ?: '—') ?></span></div>
    <div><span class="dl">Auditato</span><span class="dv"><?= e($a['auditee'] ?: '—') ?></span></div>
    <div><span class="dl">Processo</span><span class="dv"><?= e($a['proc_code'] ? $a['proc_code'].' '.$a['proc_name'] : '—') ?></span></div>
    <?php if ($a['partner_name']): ?><div><span class="dl">Partner</span><span class="dv"><?= e($a['partner_name']) ?></span></div><?php endif; ?>
    <div><span class="dl">Pianificato</span><span class="dv"><?= date_it($a['planned_date']) ?></span></div>
    <div><span class="dl">Eseguito</span><span class="dv"><?= date_it($a['executed_date']) ?></span></div>
  </div>
  <?php if ($a['scope']): ?><p class="detail-note"><strong>Scopo.</strong> <?= e($a['scope']) ?></p><?php endif; ?>
  <?php if ($a['result_summary']): ?><p class="detail-note"><strong>Esito.</strong> <?= e($a['result_summary']) ?></p><?php endif; ?>
</div>

<div class="grid-2">
  <div class="card">
    <?php section_title('Rilievi', count($findings) . ' registrati'); ?>
    <?php if (!$findings): ?>
      <?php empty_state('Nessun rilievo registrato per questo audit.', 'flag'); ?>
    <?php else: ?>
      <ul class="finding-list">
        <?php foreach ($findings as $f): ?>
          <li>
            <div class="finding-head">
              <span class="mono"><?= e($f['code']) ?></span>
              <?= badge(finding_type_label($f['type']), finding_type_tone($f['type']), 'dot') ?>
              <?php if ($f['clause_ref']): ?><span class="clause">cl. <?= e($f['clause_ref']) ?></span><?php endif; ?>
              <span class="finding-status"><?= badge($f['status']==='chiuso'?'Chiuso':($f['status']==='in_gestione'?'In gestione':'Aperto'), $f['status']==='chiuso'?'success':($f['status']==='in_gestione'?'warning':'danger')) ?></span>
            </div>
            <p><?= e($f['description']) ?></p>
            <?php if ($f['evidence']): ?><small class="muted">Evidenza: <?= e($f['evidence']) ?></small><?php endif; ?>
            <div class="finding-foot">
              <?php if ($f['owner_name']): ?><span><?= icon('people',13) ?> <?= e($f['owner_name']) ?></span><?php endif; ?>
              <?php if ($f['due_date']): ?><span class="tone-<?= due_tone($f['due_date']) ?>"><?= icon('clock',13) ?> <?= date_it($f['due_date']) ?></span><?php endif; ?>
              <?php if ($f['non_conformity_id']): ?><a class="lnk" href="index.php?page=nc_detail&id=<?= $f['non_conformity_id'] ?>">NC collegata →</a><?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <?php if (user_can_write()): ?>
      <?= add_panel_open('Aggiungi rilievo', 'save_finding') ?>
      <input type="hidden" name="audit_id" value="<?= $id ?>">
      <div class="form-grid">
        <?= field_select('type','Tipo rilievo', ['nc_maggiore'=>'NC maggiore','nc_minore'=>'NC minore','osservazione'=>'Osservazione','opportunita'=>'Opportunità','punto_forza'=>'Punto di forza'], 'osservazione', true) ?>
        <?= field_input('clause_ref','Clausola','','text','Es. 7.1.5') ?>
        <label class="field"><span>Responsabile</span><select class="input" name="owner_id"><?= users_options() ?></select></label>
        <?= field_date('due_date','Scadenza') ?>
      </div>
      <?= field_textarea('description','Descrizione','','Descrivi il rilievo') ?>
      <?= field_input('evidence','Evidenza','','text','Riferimento evidenza oggettiva') ?>
      <?= add_panel_close('Registra rilievo') ?>
    <?php endif; ?>
  </div>

  <div class="card">
    <?php section_title('Avanzamento & checklist', 'Gestisci stato ed esecuzione'); ?>
    <?php if (user_can_write()): ?>
    <form method="post" class="inline-form">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="update_audit_status">
      <input type="hidden" name="id" value="<?= $id ?>">
      <div class="form-grid">
        <?= field_select('status','Stato', ['pianificato'=>'Pianificato','in_corso'=>'In corso','rilievi'=>'Rilievi','follow_up'=>'Follow-up','chiuso'=>'Chiuso'], $a['status']) ?>
        <?= field_input('score','Punteggio (0-100)', $a['score']!==null?(string)$a['score']:'', 'number') ?>
      </div>
      <?= field_textarea('result_summary','Esito di sintesi', $a['result_summary'] ?? '') ?>
      <button class="btn btn-primary" type="submit">Aggiorna avanzamento</button>
    </form>
    <?php endif; ?>

    <div class="divider"></div>
    <h3 class="mini-title">Checklist collegate</h3>
    <?php if (!$runs): ?>
      <p class="muted">Nessuna checklist eseguita. <?php if($a['template_id'] && user_can_write()): ?>
        <form method="post" class="inline">
          <?= csrf_field() ?><input type="hidden" name="action" value="start_checklist_run">
          <input type="hidden" name="template_id" value="<?= (int)$a['template_id'] ?>">
          <input type="hidden" name="audit_id" value="<?= $id ?>">
          <input type="hidden" name="title" value="Checklist <?= e($a['code']) ?>">
          <button class="btn btn-ghost btn-sm" type="submit"><?= icon('plus',14) ?> Avvia "<?= e($a['tpl_name']) ?>"</button>
        </form>
      <?php endif; ?></p>
    <?php else: foreach ($runs as $r): ?>
      <a class="run-row" href="index.php?page=checklist_run&id=<?= $r['id'] ?>">
        <span><?= e($r['title']) ?></span>
        <span><?= $r['status']==='completata' ? '<span class="score-pill">'.(int)$r['score'].'%</span>' : badge('In corso','warning') ?></span>
      </a>
    <?php endforeach; endif; ?>
  </div>
</div>
<?php layout_end(); ?>
