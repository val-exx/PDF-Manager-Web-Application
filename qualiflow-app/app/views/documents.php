<?php
$cid = current_company_id();
$cat = $_GET['cat'] ?? '';
$where = 'd.company_id=?'; $params=[$cid];
if ($cat!=='') { $where.=' AND d.category=?'; $params[]=$cat; }
$docs = all_rows("SELECT d.*, u.name owner_name, p.code proc_code FROM documents d LEFT JOIN users u ON u.id=d.owner_id LEFT JOIN processes p ON p.id=d.process_id WHERE $where ORDER BY CASE d.category WHEN 'manuale' THEN 0 WHEN 'politica' THEN 1 WHEN 'procedura' THEN 2 ELSE 3 END, d.code", $params);
$processes = all_rows("SELECT id, code, name FROM processes WHERE company_id=? ORDER BY code", [$cid]);

$total = (int)(one("SELECT COUNT(*) c FROM documents WHERE company_id=?", [$cid])['c'] ?? 0);
$approved = (int)(one("SELECT COUNT(*) c FROM documents WHERE company_id=? AND status='approvato'", [$cid])['c'] ?? 0);
$toReview = (int)(one("SELECT COUNT(*) c FROM documents WHERE company_id=? AND review_date IS NOT NULL AND review_date <= date('now','+30 day')", [$cid])['c'] ?? 0);

$cats = ['manuale'=>'Manuali','politica'=>'Politiche','procedura'=>'Procedure','istruzione'=>'Istruzioni','modulo'=>'Moduli','registrazione'=>'Registrazioni'];

$add = add_panel_open('Nuovo documento', 'save_document');
$add .= '<div class="form-grid">';
$add .= field_input('title','Titolo','','text','Es. Procedura controllo qualità', true);
$add .= field_input('code','Codice','','text','Es. PRO-10');
$add .= field_select('category','Categoria', $cats, 'procedura');
$add .= field_input('revision','Revisione','0');
$add .= field_select('status','Stato', ['bozza'=>'Bozza','in_revisione'=>'In revisione','approvato'=>'Approvato','obsoleto'=>'Obsoleto'], 'bozza');
$prOpts='<option value="">—</option>'; foreach($processes as $p) $prOpts.='<option value="'.$p['id'].'">'.e($p['code'].' '.$p['name']).'</option>';
$add .= '<label class="field"><span>Processo</span><select class="input" name="process_id">'.$prOpts.'</select></label>';
$add .= '<label class="field"><span>Responsabile</span><select class="input" name="owner_id">'.users_options().'</select></label>';
$add .= field_date('issue_date','Data emissione');
$add .= field_date('review_date','Prossima revisione');
$add .= '</div>';
$add .= '<label class="field"><span>File</span><input class="input" type="file" name="file"></label>';
$add .= add_panel_close('Crea documento');

layout_start('Documenti & Manuali', 'documents', 'Documentazione di sistema, revisioni e scadenze', user_can_write() ? $add : '');
?>
<div class="hero-kpis kpis-3">
  <?php
    kpi_tile('Documenti', $total, 'totale a sistema', 'neutral', 'document');
    kpi_tile('Approvati', $approved, 'in vigore', 'success', 'check');
    kpi_tile('Da revisionare', $toReview, 'entro 30 giorni', $toReview?'warning':'success', 'clock');
  ?>
</div>

<div class="filter-bar">
  <a class="chip <?= $cat===''?'on':'' ?>" href="index.php?page=documents">Tutti</a>
  <?php foreach ($cats as $k=>$v): ?><a class="chip <?= $cat===$k?'on':'' ?>" href="index.php?page=documents&cat=<?= $k ?>"><?= $v ?></a><?php endforeach; ?>
</div>

<div class="card">
  <?php if (!$docs): ?>
    <?php empty_state('Nessun documento in questa categoria.', 'document'); ?>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Codice</th><th>Titolo</th><th>Cat.</th><th>Rev.</th><th>Stato</th><th>Revisione</th><?php if(user_can_write()):?><th></th><?php endif;?></tr></thead>
      <tbody>
        <?php foreach ($docs as $d): ?>
          <tr>
            <td><span class="mono"><?= e($d['code']) ?></span></td>
            <td><strong><?= e($d['title']) ?></strong><?php if($d['proc_code']):?><small class="sub"><?= e($d['proc_code']) ?></small><?php endif;?></td>
            <td><?= e(ucfirst($d['category'])) ?></td>
            <td><span class="mono">rev <?= e($d['revision']) ?></span></td>
            <td><?= badge(doc_status_label($d['status']), doc_status_tone($d['status']), 'dot') ?></td>
            <td><?= $d['review_date'] ? '<span class="tone-'.due_tone($d['review_date']).'">'.date_it($d['review_date']).'</span>' : '<span class="muted">—</span>' ?></td>
            <?php if(user_can_write()):?>
            <td class="ta-r">
              <details class="mini-menu"><summary class="icon-btn ghost"><?= icon('plus',15) ?></summary>
                <form method="post" class="menu-form" enctype="multipart/form-data">
                  <?= csrf_field() ?><input type="hidden" name="action" value="save_document_revision"><input type="hidden" name="document_id" value="<?= $d['id'] ?>">
                  <label class="field"><span>Nuova revisione</span><input class="input input-sm" name="revision" value="<?= e((string)((int)$d['revision']+1)) ?>" required></label>
                  <input class="input input-sm" name="change_note" placeholder="Motivo revisione">
                  <input class="input input-sm" type="file" name="file">
                  <button class="btn btn-primary btn-sm" type="submit">Registra revisione</button>
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
</div>
<?php layout_end(); ?>
