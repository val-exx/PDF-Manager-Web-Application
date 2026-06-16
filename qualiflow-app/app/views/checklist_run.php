<?php
$cid = current_company_id();
$id = (int)($_GET['id'] ?? 0);
$run = one("SELECT r.*, t.name tpl_name, t.standard FROM checklist_runs r LEFT JOIN checklist_templates t ON t.id=r.template_id WHERE r.id=? AND r.company_id=?", [$id, $cid]);
if (!$run) { layout_start('Checklist', 'checklists'); empty_state('Checklist non trovata.', 'checklist'); layout_end(); return; }
$items = all_rows("SELECT * FROM checklist_run_items WHERE run_id=? ORDER BY id", [$id]);

$tot = count($items);
$valued = 0; $conf = 0; $nc = 0;
foreach ($items as $it) { if ($it['answer']!=='da_valutare') $valued++; if ($it['answer']==='conforme') $conf++; if ($it['answer']==='non_conforme') $nc++; }
$progress = $tot ? round($valued/$tot*100) : 0;
$liveScore = ($conf+$nc) ? round($conf/($conf+$nc)*100) : 0;
$done = $run['status']==='completata';

layout_start('Checklist', 'checklists', $run['title']);
?>
<a class="back-lnk" href="index.php?page=checklists"><?= icon('chevron',14) ?> Tutte le checklist</a>

<div class="card run-head">
  <div class="run-head-main">
    <span class="tpl-std"><?= e($run['standard']) ?></span>
    <h2 class="detail-title"><?= e($run['title']) ?></h2>
    <p class="muted"><?= e($run['tpl_name']) ?> · auditor <?= e($run['auditor']) ?> · <?= date_it($run['run_date']) ?></p>
    <div class="run-progress">
      <?= progress_bar($progress) ?>
      <span><?= $valued ?>/<?= $tot ?> valutati</span>
    </div>
  </div>
  <div class="run-head-side">
    <?= ring($done ? (int)$run['score'] : $liveScore, 110, 12, $done?($run['score']>=80?'success':'warning'):'primary', ($done?(int)$run['score']:$liveScore).'%', $done?'finale':'parziale') ?>
    <?php if ($done): ?>
      <div class="run-stats"><span class="tone-success"><?= (int)$run['conform_count'] ?> conformi</span><span class="tone-danger"><?= (int)$run['nc_count'] ?> NC</span></div>
    <?php endif; ?>
  </div>
</div>

<div class="card">
  <?php section_title('Punti di verifica', $done ? 'Checklist completata' : 'Rispondi a ciascun punto'); ?>
  <ul class="check-items">
    <?php foreach ($items as $i => $it): ?>
      <li class="check-item answer-<?= e($it['answer']) ?>">
        <div class="check-q">
          <span class="check-n"><?= $i+1 ?></span>
          <div>
            <p class="check-text"><?= e($it['question']) ?></p>
            <?php if ($it['clause_code']): ?><span class="clause">cl. <?= e($it['clause_code']) ?></span><?php endif; ?>
            <?php if ($it['notes']): ?><p class="check-note"><?= e($it['notes']) ?></p><?php endif; ?>
          </div>
        </div>
        <?php if (!$done && user_can_write()): ?>
        <form method="post" class="check-answers">
          <?= csrf_field() ?><input type="hidden" name="action" value="save_run_item">
          <input type="hidden" name="run_id" value="<?= $id ?>"><input type="hidden" name="item_id" value="<?= $it['id'] ?>">
          <div class="seg">
            <?php foreach (['conforme'=>'C','non_conforme'=>'NC','osservazione'=>'Oss','na'=>'N/A'] as $val=>$lbl): ?>
              <button class="seg-btn seg-<?= $val ?> <?= $it['answer']===$val?'on':'' ?>" name="answer" value="<?= $val ?>" title="<?= answer_label($val) ?>"><?= $lbl ?></button>
            <?php endforeach; ?>
          </div>
          <input class="input input-sm check-note-input" type="text" name="notes" value="<?= e($it['notes']) ?>" placeholder="Nota (poi scegli un esito)">
        </form>
        <?php else: ?>
          <?= badge(answer_label($it['answer']), answer_tone($it['answer']), 'dot') ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>

  <?php if (!$done && user_can_write()): ?>
    <form method="post" class="run-complete" onsubmit="return confirm('Completare la checklist? Verrà calcolato il punteggio finale.');">
      <?= csrf_field() ?><input type="hidden" name="action" value="complete_run"><input type="hidden" name="id" value="<?= $id ?>">
      <button class="btn btn-primary" type="submit" <?= $valued<$tot?'':'' ?>><?= icon('check',16) ?> Completa checklist</button>
      <?php if ($valued<$tot): ?><span class="muted">Puoi completare anche con punti non valutati.</span><?php endif; ?>
    </form>
  <?php endif; ?>
</div>
<?php layout_end(); ?>
