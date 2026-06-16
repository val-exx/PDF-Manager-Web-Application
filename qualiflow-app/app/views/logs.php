<?php
$cid = current_company_id();
$logs = all_rows("SELECT al.*, u.name uname FROM activity_logs al LEFT JOIN users u ON u.id=al.user_id WHERE al.company_id=? ORDER BY al.created_at DESC LIMIT 200", [$cid]);

$icons = [
  'audit'=>'audit','non_conformity'=>'nc','corrective_action'=>'check','checklist_run'=>'checklist',
  'process'=>'process','document'=>'document','machine'=>'wrench','instrument'=>'wrench',
  'person'=>'people','partner'=>'partner','activity'=>'calendar','company'=>'building',
];
layout_start('Registro attività', 'logs', 'Tracciabilità delle operazioni');
?>
<div class="card">
  <?php section_title('Cronologia', count($logs).' eventi recenti'); ?>
  <?php if (!$logs): empty_state('Nessuna attività registrata.','log'); else: ?>
  <ul class="log-list">
    <?php foreach ($logs as $l): ?>
      <li class="log-row">
        <span class="log-ic"><?= icon($icons[$l['subject_type']] ?? 'log', 16) ?></span>
        <div class="log-body">
          <p><?= e($l['description']) ?></p>
          <small><?= e($l['uname'] ?? 'Sistema') ?> · <?= datetime_it($l['created_at']) ?></small>
        </div>
        <span class="log-tag mono"><?= e($l['action']) ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</div>
<?php layout_end(); ?>
