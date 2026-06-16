<?php
$cid = current_company_id();
$id = (int)($_GET['id'] ?? 0);
$n = one("SELECT nc.*, p.name partner_name, u.name owner_name, pr.code proc_code, pr.name proc_name
          FROM non_conformities nc
          LEFT JOIN partners p ON p.id=nc.partner_id
          LEFT JOIN users u ON u.id=nc.owner_id
          LEFT JOIN processes pr ON pr.id=nc.process_id
          WHERE nc.id=? AND nc.company_id=?", [$id, $cid]);
if (!$n) { layout_start('Non conformità', 'nc'); empty_state('Non conformità non trovata.', 'nc'); layout_end(); return; }

$actions = all_rows("SELECT ca.*, u.name owner_name FROM corrective_actions ca LEFT JOIN users u ON u.id=ca.owner_id WHERE ca.non_conformity_id=? ORDER BY ca.id", [$id]);

$ncFlow = ['aperta','contenimento','analisi','azioni','verifica','chiusa'];
$ncLabels = ['aperta'=>'Aperta','contenimento'=>'Contenimento','analisi'=>'Analisi','azioni'=>'Azioni','verifica'=>'Verifica','chiusa'=>'Chiusa'];
$ncIdx = array_search($n['status'], $ncFlow, true);
$ncSteps = [];
foreach ($ncFlow as $i=>$s) $ncSteps[] = ['label'=>$ncLabels[$s],'done'=>$i<$ncIdx,'current'=>$i===$ncIdx,'n'=>$i+1];

/* 8D */
$dSteps = [
  ['k'=>'d1_team','t'=>'D1 · Team','h'=>'Componenti del team interfunzionale'],
  ['k'=>'d2_problem','t'=>'D2 · Descrizione problema','h'=>'Cosa, dove, quando, quanto (5W2H)'],
  ['k'=>'d3_containment','t'=>'D3 · Azioni di contenimento','h'=>'Protezione immediata del cliente'],
  ['k'=>'d4_rootcause','t'=>'D4 · Analisi cause','h'=>'Cause radice (5 perché / Ishikawa)'],
  ['k'=>'d5_actions','t'=>'D5 · Azioni correttive','h'=>'Azioni scelte per eliminare la causa'],
  ['k'=>'d6_implementation','t'=>'D6 · Implementazione','h'=>'Attuazione e verifica efficacia'],
  ['k'=>'d7_prevention','t'=>'D7 · Prevenzione','h'=>'Standardizzazione, PFMEA, control plan'],
  ['k'=>'d8_closure','t'=>'D8 · Chiusura','h'=>'Riconoscimento team e chiusura'],
];
$dCur = (int)$n['d_step'];

layout_start('NC ' . $n['code'], 'nc', $n['title']);
?>
<a class="back-lnk" href="index.php?page=nc"><?= icon('chevron',14) ?> Tutte le non conformità</a>

<div class="card">
  <div class="detail-head">
    <div>
      <span class="mono badge badge-neutral"><?= e($n['code']) ?></span>
      <?= badge(nc_source_label($n['source']), 'info') ?>
      <?= badge(ucfirst($n['severity']).' gravità', severity_tone($n['severity']), 'dot') ?>
      <?php if ($n['method']==='8d'): ?><?= badge('Metodo 8D','info') ?><?php endif; ?>
    </div>
    <?= badge(nc_status_label($n['status']), nc_status_tone($n['status']), 'dot') ?>
  </div>
  <h2 class="detail-title"><?= e($n['title']) ?></h2>
  <?= stepper($ncSteps) ?>
  <div class="detail-grid">
    <div><span class="dl">Responsabile</span><span class="dv"><?= e($n['owner_name'] ?: '—') ?></span></div>
    <div><span class="dl">Rilevata</span><span class="dv"><?= date_it($n['detected_at']) ?></span></div>
    <div><span class="dl">Scadenza</span><span class="dv tone-<?= due_tone($n['due_date']) ?>"><?= date_it($n['due_date']) ?></span></div>
    <?php if ($n['partner_name']): ?><div><span class="dl">Partner</span><span class="dv"><?= e($n['partner_name']) ?></span></div><?php endif; ?>
    <?php if ($n['proc_code']): ?><div><span class="dl">Processo</span><span class="dv"><?= e($n['proc_code'].' '.$n['proc_name']) ?></span></div><?php endif; ?>
    <?php if ($n['cost_estimate']): ?><div><span class="dl">Costo stimato</span><span class="dv">€ <?= it_num($n['cost_estimate']) ?></span></div><?php endif; ?>
  </div>
  <?php if ($n['description']): ?><p class="detail-note"><?= e($n['description']) ?></p><?php endif; ?>

  <?php if (user_can_write()): ?>
  <form method="post" class="status-inline">
    <?= csrf_field() ?><input type="hidden" name="action" value="update_nc_status"><input type="hidden" name="id" value="<?= $id ?>">
    <label class="field inline-field"><span>Avanza stato</span><select class="input" name="status">
      <?php foreach ($ncLabels as $k=>$v): ?><option value="<?= $k ?>" <?= $k===$n['status']?'selected':'' ?>><?= $v ?></option><?php endforeach; ?>
    </select></label>
    <button class="btn btn-primary" type="submit">Aggiorna</button>
  </form>
  <?php endif; ?>
</div>

<?php if ($n['method']==='8d'): ?>
<div class="card eightd">
  <?php section_title('Report 8D', 'Le 8 discipline · step corrente ' . max(1,$dCur) . '/8'); ?>
  <ol class="stepper stepper-8d">
    <?php foreach ($dSteps as $i=>$ds): $done=($i+1)<$dCur; $curr=($i+1)===$dCur; ?>
      <li class="step <?= $done?'done':($curr?'current':'') ?>"><span class="step-dot"><?= $done?icon('check',13):($i+1) ?></span><span class="step-lbl">D<?= $i+1 ?></span></li>
    <?php endforeach; ?>
  </ol>

  <div class="eightd-grid">
    <?php foreach ($dSteps as $i=>$ds): $val=$n[$ds['k']]; $state=($i+1)<$dCur?'done':(($i+1)===$dCur?'current':'todo'); ?>
      <div class="dcard dcard-<?= $state ?>">
        <div class="dcard-head"><strong><?= e($ds['t']) ?></strong><?php if($state==='done'):?><?= badge('Completato','success') ?><?php elseif($state==='current'):?><?= badge('In corso','warning') ?><?php endif;?></div>
        <p class="dcard-hint"><?= e($ds['h']) ?></p>
        <?php if ($val): ?><p class="dcard-val"><?= nl2br(e($val)) ?></p><?php else: ?><p class="dcard-empty">Da compilare</p><?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <?php if (user_can_write()): ?>
  <details class="addp">
    <summary class="btn btn-ghost"><?= icon('plus',16) ?> Compila / aggiorna 8D</summary>
    <form method="post" class="addp-form card">
      <?= csrf_field() ?><input type="hidden" name="action" value="save_8d"><input type="hidden" name="id" value="<?= $id ?>">
      <?php foreach ($dSteps as $ds): ?>
        <label class="field"><span><?= e($ds['t']) ?></span><textarea class="input" name="<?= $ds['k'] ?>" placeholder="<?= e($ds['h']) ?>"><?= e($n[$ds['k']]) ?></textarea></label>
      <?php endforeach; ?>
      <label class="field"><span>Step corrente (0–8)</span>
        <select class="input" name="d_step">
          <?php for ($i=0;$i<=8;$i++): ?><option value="<?= $i ?>" <?= $i===$dCur?'selected':'' ?>><?= $i===0?'Non avviato':"D$i" ?></option><?php endfor; ?>
        </select>
      </label>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Salva report 8D</button></div>
    </form>
  </details>
  <?php endif; ?>
</div>
<?php endif; ?>

<div class="card">
  <?php section_title('Azioni correttive', count($actions) . ' azioni'); ?>
  <?php if (!$actions): ?>
    <?php empty_state('Nessuna azione correttiva. Aggiungi la prima azione.', 'check'); ?>
  <?php else: ?>
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Azione</th><th>Responsabile</th><th>Scadenza</th><th>Stato</th><?php if(user_can_write()):?><th></th><?php endif;?></tr></thead>
        <tbody>
        <?php foreach ($actions as $ca):
          $st = $ca['status'];
          $tone = match($st){'verificata'=>'success','completata'=>'success','in_lavorazione'=>'warning','inefficace'=>'danger',default=>'neutral'};
        ?>
          <tr>
            <td><strong><?= e($ca['title']) ?></strong><?php if($ca['root_cause']):?><small class="sub">Causa: <?= e($ca['root_cause']) ?></small><?php endif;?></td>
            <td><?= e($ca['owner_name'] ?: '—') ?></td>
            <td><span class="tone-<?= due_tone($ca['due_date']) ?>"><?= date_it($ca['due_date']) ?></span></td>
            <td><?= badge(ucfirst(str_replace('_',' ',$st)), $tone, 'dot') ?></td>
            <?php if(user_can_write()):?>
            <td class="ta-r">
              <details class="mini-menu"><summary class="icon-btn ghost"><?= icon('settings',15) ?></summary>
                <form method="post" class="menu-form">
                  <?= csrf_field() ?><input type="hidden" name="action" value="update_action_status">
                  <input type="hidden" name="id" value="<?= $ca['id'] ?>"><input type="hidden" name="non_conformity_id" value="<?= $id ?>">
                  <select class="input input-sm" name="status">
                    <?php foreach(['aperta','in_lavorazione','completata','verificata','inefficace'] as $o):?><option value="<?= $o ?>" <?= $o===$st?'selected':'' ?>><?= ucfirst(str_replace('_',' ',$o)) ?></option><?php endforeach;?>
                  </select>
                  <input class="input input-sm" type="text" name="effectiveness_check" placeholder="Nota efficacia">
                  <button class="btn btn-primary btn-sm" type="submit">Salva</button>
                </form>
              </details>
            </td>
            <?php endif;?>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <?php if (user_can_write()): ?>
    <?= add_panel_open('Aggiungi azione correttiva', 'save_corrective_action') ?>
    <input type="hidden" name="non_conformity_id" value="<?= $id ?>">
    <div class="form-grid">
      <?= field_input('title','Titolo azione','','text','Es. Aggiungere controllo in-process', true) ?>
      <label class="field"><span>Responsabile</span><select class="input" name="owner_id"><?= users_options() ?></select></label>
      <?= field_input('root_cause','Causa radice','','text','Causa individuata') ?>
      <?= field_date('due_date','Scadenza') ?>
    </div>
    <?= field_textarea('description','Descrizione','','Dettaglio dell\'azione') ?>
    <?= add_panel_close('Aggiungi azione') ?>
  <?php endif; ?>
</div>
<?php layout_end(); ?>
