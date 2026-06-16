<?php
$cid = current_company_id();
$templates = all_rows("SELECT t.*, (SELECT COUNT(*) FROM checklist_items ci WHERE ci.template_id=t.id) item_count FROM checklist_templates t WHERE t.company_id IS NULL OR t.company_id=? ORDER BY t.standard, t.id", [$cid]);
$runs = all_rows("SELECT r.*, t.name tpl_name FROM checklist_runs r LEFT JOIN checklist_templates t ON t.id=r.template_id WHERE r.company_id=? ORDER BY r.id DESC LIMIT 12", [$cid]);

layout_start('Checklist', 'checklists', 'Modelli pronti per ISO 9001 e IATF 16949');
?>
<section>
  <?php section_title('Modelli di checklist', 'Avvia una verifica da un modello pronto all\'uso'); ?>
  <div class="card-grid">
    <?php foreach ($templates as $t): ?>
      <div class="tpl-card card">
        <div class="tpl-top">
          <span class="tpl-std"><?= e($t['standard']) ?></span>
          <span class="tpl-count"><?= (int)$t['item_count'] ?> punti</span>
        </div>
        <h3><?= e($t['name']) ?></h3>
        <p class="muted"><?= e($t['description']) ?></p>
        <?php if (user_can_write()): ?>
        <form method="post">
          <?= csrf_field() ?><input type="hidden" name="action" value="start_checklist_run"><input type="hidden" name="template_id" value="<?= $t['id'] ?>">
          <button class="btn btn-primary btn-block" type="submit"><?= icon('checklist',16) ?> Avvia checklist</button>
        </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="card">
  <?php section_title('Esecuzioni recenti', 'Storico delle checklist svolte'); ?>
  <?php if (!$runs): ?>
    <?php empty_state('Nessuna checklist eseguita. Avvia la prima da un modello.', 'checklist'); ?>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Checklist</th><th>Auditor</th><th>Data</th><th>Esito</th><th>Stato</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($runs as $r): ?>
          <tr>
            <td><a class="lnk" href="index.php?page=checklist_run&id=<?= $r['id'] ?>"><?= e($r['title']) ?></a><small class="sub"><?= e($r['tpl_name']) ?></small></td>
            <td><?= e($r['auditor'] ?: '—') ?></td>
            <td><?= date_it($r['run_date']) ?></td>
            <td><?php if($r['status']==='completata'): ?><span class="score-pill"><?= (int)$r['score'] ?>%</span> <small class="muted"><?= (int)$r['nc_count'] ?> NC</small><?php else: ?><span class="muted">—</span><?php endif; ?></td>
            <td><?= $r['status']==='completata' ? badge('Completata','success','dot') : badge('In corso','warning','dot') ?></td>
            <td class="ta-r"><a class="icon-btn ghost" href="index.php?page=checklist_run&id=<?= $r['id'] ?>"><?= icon('chevron',16) ?></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</section>
<?php layout_end(); ?>
