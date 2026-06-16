<?php
$cid = current_company_id();
$src = $_GET['source'] ?? '';
$where = 'nc.company_id = ?'; $params = [$cid];
if (in_array($src, ['interna','cliente','fornitore','audit','processo','reclamo'], true)) { $where .= ' AND nc.source = ?'; $params[] = $src; }
$ncs = all_rows("SELECT nc.*, p.name partner_name, u.name owner_name FROM non_conformities nc LEFT JOIN partners p ON p.id=nc.partner_id LEFT JOIN users u ON u.id=nc.owner_id WHERE $where ORDER BY CASE nc.status WHEN 'chiusa' THEN 1 ELSE 0 END, nc.detected_at DESC", $params);

$open = (int)(one("SELECT COUNT(*) c FROM non_conformities WHERE company_id=? AND status!='chiusa'", [$cid])['c'] ?? 0);
$eightD = (int)(one("SELECT COUNT(*) c FROM non_conformities WHERE company_id=? AND method='8d' AND status!='chiusa'", [$cid])['c'] ?? 0);
$ext = (int)(one("SELECT COUNT(*) c FROM non_conformities WHERE company_id=? AND source IN ('cliente','fornitore','reclamo') AND status!='chiusa'", [$cid])['c'] ?? 0);
$overdueNc = (int)(one("SELECT COUNT(*) c FROM non_conformities WHERE company_id=? AND status!='chiusa' AND due_date < date('now')", [$cid])['c'] ?? 0);

$partners = all_rows("SELECT id, name, kind FROM partners WHERE company_id=? ORDER BY name", [$cid]);
$processes = all_rows("SELECT id, code, name FROM processes WHERE company_id=? ORDER BY code", [$cid]);

$add = add_panel_open('Apri non conformità', 'save_nc');
$add .= '<div class="form-grid">';
$add .= field_input('title','Titolo','','text','Descrizione sintetica', true);
$add .= field_select('source','Origine', ['interna'=>'Interna','cliente'=>'Cliente','fornitore'=>'Fornitore','audit'=>'Da audit','processo'=>'Di processo','reclamo'=>'Reclamo cliente'], 'interna', true);
$add .= field_select('severity','Gravità', ['bassa'=>'Bassa','media'=>'Media','alta'=>'Alta','critica'=>'Critica'], 'media');
$add .= field_select('method','Metodo', ['standard'=>'Standard','8d'=>'8D (8 Discipline)'], 'standard');
$pOpts = '<option value="">—</option>'; foreach ($partners as $p) $pOpts .= '<option value="'.$p['id'].'">'.e($p['name']).' ('.e($p['kind']).')</option>';
$add .= '<label class="field"><span>Cliente / Fornitore</span><select class="input" name="partner_id">'.$pOpts.'</select></label>';
$prOpts = '<option value="">—</option>'; foreach ($processes as $p) $prOpts .= '<option value="'.$p['id'].'">'.e($p['code'].' '.$p['name']).'</option>';
$add .= '<label class="field"><span>Processo</span><select class="input" name="process_id">'.$prOpts.'</select></label>';
$add .= '<label class="field"><span>Responsabile</span><select class="input" name="owner_id">'.users_options((int)current_user()['id']).'</select></label>';
$add .= field_date('detected_at','Rilevata il');
$add .= field_date('due_date','Scadenza gestione');
$add .= '</div>';
$add .= field_textarea('description','Descrizione','','Cosa è successo, dove, impatto');
$add .= add_panel_close('Apri NC');

layout_start('Non conformità', 'nc', 'Interne, da cliente e da fornitore — con metodo 8D', user_can_write() ? $add : '');
?>
<div class="hero-kpis kpis-4">
  <?php
    kpi_tile('NC aperte', $open, 'in gestione', $open?'danger':'success', 'nc');
    kpi_tile('In ritardo', $overdueNc, 'oltre la scadenza', $overdueNc?'danger':'success', 'clock');
    kpi_tile('Esterne aperte', $ext, 'cliente / fornitore', $ext?'warning':'success', 'partner');
    kpi_tile('Con 8D attivo', $eightD, 'gestione strutturata', $eightD?'info':'success', 'shield');
  ?>
</div>

<div class="filter-bar">
  <a class="chip <?= $src===''?'on':'' ?>" href="index.php?page=nc">Tutte</a>
  <a class="chip <?= $src==='interna'?'on':'' ?>" href="index.php?page=nc&source=interna">Interne</a>
  <a class="chip <?= $src==='cliente'?'on':'' ?>" href="index.php?page=nc&source=cliente">Cliente</a>
  <a class="chip <?= $src==='reclamo'?'on':'' ?>" href="index.php?page=nc&source=reclamo">Reclami</a>
  <a class="chip <?= $src==='fornitore'?'on':'' ?>" href="index.php?page=nc&source=fornitore">Fornitore</a>
  <a class="chip <?= $src==='audit'?'on':'' ?>" href="index.php?page=nc&source=audit">Da audit</a>
  <a class="chip <?= $src==='processo'?'on':'' ?>" href="index.php?page=nc&source=processo">Processo</a>
</div>

<div class="card">
  <?php if (!$ncs): ?>
    <?php empty_state('Nessuna non conformità registrata.', 'nc'); ?>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Codice</th><th>Titolo</th><th>Origine</th><th>Gravità</th><th>Metodo</th><th>Scadenza</th><th>Stato</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($ncs as $n): ?>
          <tr>
            <td><span class="mono"><?= e($n['code']) ?></span></td>
            <td><a class="lnk" href="index.php?page=nc_detail&id=<?= $n['id'] ?>"><?= e($n['title']) ?></a><?php if($n['partner_name']):?><small class="sub"><?= e($n['partner_name']) ?></small><?php endif;?></td>
            <td><?= badge(nc_source_label($n['source']), 'neutral') ?></td>
            <td><?= badge(ucfirst($n['severity']), severity_tone($n['severity']), 'dot') ?></td>
            <td><?= $n['method']==='8d' ? badge('8D','info') : '<span class="muted">Standard</span>' ?></td>
            <td><?= $n['status']==='chiusa' ? '<span class="muted">—</span>' : '<span class="tone-'.due_tone($n['due_date']).'">'.date_it($n['due_date']).'</span>' ?></td>
            <td><?= badge(nc_status_label($n['status']), nc_status_tone($n['status']), 'dot') ?></td>
            <td class="ta-r"><a class="icon-btn ghost" href="index.php?page=nc_detail&id=<?= $n['id'] ?>"><?= icon('chevron',16) ?></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
<?php layout_end(); ?>
