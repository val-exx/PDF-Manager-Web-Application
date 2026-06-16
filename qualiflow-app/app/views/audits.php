<?php
$cid = current_company_id();
$filter = $_GET['type'] ?? '';
$where = 'a.company_id = ?';
$params = [$cid];
if (in_array($filter, ['interno','esterno_ente','fornitore','cliente'], true)) { $where .= ' AND a.audit_type = ?'; $params[] = $filter; }
$audits = all_rows("SELECT a.*, p.name partner_name, u.name auditor_name FROM audits a LEFT JOIN partners p ON p.id=a.partner_id LEFT JOIN users u ON u.id=a.lead_auditor_id WHERE $where ORDER BY COALESCE(a.executed_date,a.planned_date) DESC", $params);
$templates = all_rows("SELECT * FROM checklist_templates WHERE company_id IS NULL OR company_id = ? ORDER BY id", [$cid]);
$partners = all_rows("SELECT id, name, kind FROM partners WHERE company_id=? ORDER BY name", [$cid]);
$processes = all_rows("SELECT id, code, name FROM processes WHERE company_id=? ORDER BY code", [$cid]);

$counts = [];
foreach (all_rows("SELECT audit_type, COUNT(*) c FROM audits WHERE company_id=? GROUP BY audit_type", [$cid]) as $r) $counts[$r['audit_type']] = $r['c'];

$add = add_panel_open('Pianifica audit', 'save_audit');
$add .= '<div class="form-grid">';
$add .= field_input('title','Titolo audit','','text','Es. Audit interno processo Produzione', true);
$add .= field_select('audit_type','Tipo', ['interno'=>'Interno','esterno_ente'=>'Esterno / Ente','fornitore'=>'Fornitore','cliente'=>'Cliente'], 'interno', true);
$add .= field_input('standard','Norma','','text','ISO 9001:2015 / IATF 16949:2016');
$add .= '<label class="field"><span>Lead auditor</span><select class="input" name="lead_auditor_id">'.users_options((int)current_user()['id']).'</select></label>';
$pOpts = '<option value="">—</option>'; foreach ($partners as $p) $pOpts .= '<option value="'.$p['id'].'">'.e($p['name']).' ('.e($p['kind']).')</option>';
$add .= '<label class="field"><span>Cliente / Fornitore</span><select class="input" name="partner_id">'.$pOpts.'</select></label>';
$prOpts = '<option value="">—</option>'; foreach ($processes as $p) $prOpts .= '<option value="'.$p['id'].'">'.e($p['code'].' '.$p['name']).'</option>';
$add .= '<label class="field"><span>Processo</span><select class="input" name="process_id">'.$prOpts.'</select></label>';
$tOpts = '<option value="">—</option>'; foreach ($templates as $t) $tOpts .= '<option value="'.$t['id'].'">'.e($t['name']).'</option>';
$add .= '<label class="field"><span>Checklist</span><select class="input" name="template_id">'.$tOpts.'</select></label>';
$add .= field_date('planned_date','Data pianificata');
$add .= field_input('auditee','Auditato','','text','Reparto / referente');
$add .= '</div>';
$add .= field_textarea('scope','Scopo','','Aree e processi coperti');
$add .= add_panel_close('Pianifica audit');

layout_start('Audit', 'audits', 'Audit interni, di certificazione, fornitore e cliente', user_can_write() ? $add : '');
?>
<div class="filter-bar">
  <a class="chip <?= $filter===''?'on':'' ?>" href="index.php?page=audits">Tutti <b><?= array_sum($counts) ?></b></a>
  <a class="chip <?= $filter==='interno'?'on':'' ?>" href="index.php?page=audits&type=interno">Interni <b><?= $counts['interno']??0 ?></b></a>
  <a class="chip <?= $filter==='esterno_ente'?'on':'' ?>" href="index.php?page=audits&type=esterno_ente">Ente <b><?= $counts['esterno_ente']??0 ?></b></a>
  <a class="chip <?= $filter==='fornitore'?'on':'' ?>" href="index.php?page=audits&type=fornitore">Fornitore <b><?= $counts['fornitore']??0 ?></b></a>
  <a class="chip <?= $filter==='cliente'?'on':'' ?>" href="index.php?page=audits&type=cliente">Cliente <b><?= $counts['cliente']??0 ?></b></a>
</div>

<div class="card">
  <?php if (!$audits): ?>
    <?php empty_state('Nessun audit registrato. Pianifica il primo audit.', 'audit'); ?>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Codice</th><th>Audit</th><th>Tipo</th><th>Data</th><th>Esito</th><th>Stato</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($audits as $a): ?>
          <tr>
            <td><span class="mono"><?= e($a['code']) ?></span></td>
            <td>
              <a class="lnk" href="index.php?page=audit_detail&id=<?= $a['id'] ?>"><?= e($a['title']) ?></a>
              <?php if ($a['partner_name']): ?><small class="sub"><?= e($a['partner_name']) ?></small><?php endif; ?>
            </td>
            <td><?= badge(audit_type_label($a['audit_type']), 'neutral') ?></td>
            <td><?= date_it($a['executed_date'] ?: $a['planned_date']) ?></td>
            <td><?= $a['score']!==null ? '<span class="score-pill">'.(int)$a['score'].'</span>' : '<span class="muted">—</span>' ?></td>
            <td><?= badge(audit_status_label($a['status']), audit_status_tone($a['status']), 'dot') ?></td>
            <td class="ta-r"><a class="icon-btn ghost" href="index.php?page=audit_detail&id=<?= $a['id'] ?>"><?= icon('chevron',16) ?></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
<?php layout_end(); ?>
