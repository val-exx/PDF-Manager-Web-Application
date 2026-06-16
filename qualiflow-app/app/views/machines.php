<?php
$cid = current_company_id();
$machines = all_rows("SELECT m.*, u.name owner_name,
    (SELECT performed_at FROM maintenance_records r WHERE r.machine_id=m.id ORDER BY performed_at DESC LIMIT 1) last_maint,
    (SELECT MIN(next_due_date) FROM maintenance_plans pl WHERE pl.machine_id=m.id) next_due
    FROM machines m LEFT JOIN users u ON u.id=m.owner_id WHERE m.company_id=? ORDER BY m.code", [$cid]);
$records = all_rows("SELECT r.*, m.code mcode, m.name mname FROM maintenance_records r JOIN machines m ON m.id=r.machine_id WHERE r.company_id=? ORDER BY r.performed_at DESC LIMIT 10", [$cid]);
$instruments = all_rows("SELECT i.*, u.name owner_name FROM instruments i LEFT JOIN users u ON u.id=i.owner_id WHERE i.company_id=? ORDER BY CASE i.status WHEN 'scaduto' THEN 0 WHEN 'in_scadenza' THEN 1 ELSE 2 END, i.next_calibration", [$cid]);

$instOk=$instExp=$instSoon=0;
foreach($instruments as $i){ if($i['status']==='scaduto')$instExp++; elseif($i['status']==='in_scadenza')$instSoon++; else $instOk++; }

$addM = add_panel_open('Nuova macchina', 'save_machine');
$addM .= '<div class="form-grid">'.field_input('name','Nome','','text','Es. Centro di lavoro',true).field_input('code','Codice','','text','Es. CNC-03').field_input('department','Reparto').field_input('manufacturer','Costruttore').field_input('serial_number','Matricola').field_select('status','Stato',['attiva'=>'Attiva','ferma'=>'Ferma','dismessa'=>'Dismessa'],'attiva').'</div>';
$addM .= add_panel_close('Crea macchina');

layout_start('Manutenzione', 'machines', 'Macchine, interventi e strumenti di misura (tarature)', user_can_write() ? $addM : '');
?>
<section class="card">
  <?php section_title('Macchine e impianti', count($machines).' registrate'); ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Codice</th><th>Macchina</th><th>Reparto</th><th>Ultimo intervento</th><th>Prossima</th><th>Stato</th><?php if(user_can_write()):?><th></th><?php endif;?></tr></thead>
      <tbody>
        <?php foreach ($machines as $m): ?>
          <tr>
            <td><span class="mono"><?= e($m['code']) ?></span></td>
            <td><strong><?= e($m['name']) ?></strong><?php if($m['manufacturer']):?><small class="sub"><?= e($m['manufacturer']) ?></small><?php endif;?></td>
            <td><?= e($m['department'] ?: '—') ?></td>
            <td><?= date_it($m['last_maint']) ?></td>
            <td><?= $m['next_due'] ? '<span class="tone-'.due_tone($m['next_due']).'">'.date_it($m['next_due']).'</span>' : '<span class="muted">—</span>' ?></td>
            <td><?= badge(ucfirst($m['status']), machine_status_tone($m['status']), 'dot') ?></td>
            <?php if(user_can_write()):?>
            <td class="ta-r">
              <details class="mini-menu"><summary class="icon-btn ghost"><?= icon('wrench',15) ?></summary>
                <form method="post" class="menu-form" enctype="multipart/form-data">
                  <?= csrf_field() ?><input type="hidden" name="action" value="save_maintenance_record"><input type="hidden" name="machine_id" value="<?= $m['id'] ?>">
                  <label class="field"><span>Tipo</span><select class="input input-sm" name="type"><option value="preventiva">Preventiva</option><option value="straordinaria">Straordinaria</option><option value="predittiva">Predittiva</option><option value="guasto">Guasto</option></select></label>
                  <label class="field"><span>Esito</span><select class="input input-sm" name="result"><option value="ok">OK</option><option value="parziale">Parziale</option><option value="ko">KO</option></select></label>
                  <input class="input input-sm" type="date" name="performed_at" value="<?= date('Y-m-d') ?>">
                  <input class="input input-sm" name="notes" placeholder="Note intervento">
                  <button class="btn btn-primary btn-sm" type="submit">Registra intervento</button>
                </form>
              </details>
            </td>
            <?php endif;?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<section class="card">
  <?php section_title('Strumenti di misura · Tarature', 'IATF 16949 — 7.1.5', '<span class="inline-stats"><b class="tone-danger">'.$instExp.'</b> scaduti · <b class="tone-warning">'.$instSoon.'</b> in scadenza · <b class="tone-success">'.$instOk.'</b> idonei</span>'); ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Codice</th><th>Strumento</th><th>Ubicazione</th><th>Ultima taratura</th><th>Prossima</th><th>Stato</th><?php if(user_can_write()):?><th></th><?php endif;?></tr></thead>
      <tbody>
        <?php foreach ($instruments as $i): ?>
          <tr>
            <td><span class="mono"><?= e($i['code']) ?></span></td>
            <td><strong><?= e($i['name']) ?></strong><?php if($i['type']):?><small class="sub"><?= e($i['type']) ?></small><?php endif;?></td>
            <td><?= e($i['location'] ?: '—') ?></td>
            <td><?= date_it($i['last_calibration']) ?></td>
            <td><span class="tone-<?= due_tone($i['next_calibration'],30) ?>"><?= date_it($i['next_calibration']) ?></span></td>
            <td><?= badge(ucfirst(str_replace('_',' ',$i['status'])), instrument_status_tone($i['status']), 'dot') ?></td>
            <?php if(user_can_write()):?>
            <td class="ta-r">
              <details class="mini-menu"><summary class="icon-btn ghost"><?= icon('check',15) ?></summary>
                <form method="post" class="menu-form">
                  <?= csrf_field() ?><input type="hidden" name="action" value="log_calibration"><input type="hidden" name="id" value="<?= $i['id'] ?>">
                  <label class="field"><span>Eseguita il</span><input class="input input-sm" type="date" name="last_calibration" value="<?= date('Y-m-d') ?>"></label>
                  <label class="field"><span>Prossima</span><input class="input input-sm" type="date" name="next_calibration"></label>
                  <button class="btn btn-primary btn-sm" type="submit">Registra taratura</button>
                </form>
              </details>
            </td>
            <?php endif;?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php if (user_can_write()): ?>
    <?= add_panel_open('Nuovo strumento', 'save_instrument') ?>
    <div class="form-grid">
      <?= field_input('name','Nome','','text','Es. Calibro digitale',true) ?>
      <?= field_input('code','Codice','','text','Es. STR-07') ?>
      <?= field_input('type','Tipo','','text','Es. Calibro') ?>
      <?= field_input('location','Ubicazione','','text','Es. Sala metrologia') ?>
      <?= field_input('calibration_frequency','Frequenza','','text','Es. Annuale') ?>
      <?= field_date('last_calibration','Ultima taratura') ?>
      <?= field_date('next_calibration','Prossima taratura') ?>
    </div>
    <?= add_panel_close('Crea strumento') ?>
  <?php endif; ?>
</section>

<section class="card">
  <?php section_title('Interventi recenti', 'Ultime registrazioni di manutenzione'); ?>
  <?php if(!$records): empty_state('Nessun intervento registrato.','wrench'); else: ?>
  <ul class="link-list">
    <?php foreach($records as $r): $rt=$r['result']==='ok'?'success':($r['result']==='parziale'?'warning':'danger'); ?>
      <li>
        <span><span class="mono"><?= e($r['mcode']) ?></span> <?= e($r['mname']) ?> — <?= e(ucfirst($r['type'])) ?> <small class="muted">· <?= date_it($r['performed_at']) ?> · <?= e($r['performed_by']) ?></small></span>
        <?= badge(strtoupper($r['result']), $rt) ?>
      </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</section>
<?php layout_end(); ?>
