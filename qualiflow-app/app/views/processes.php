<?php
$cid = current_company_id();
$processes = all_rows("SELECT p.*, u.name owner_name,
    (SELECT COUNT(*) FROM process_indicators i WHERE i.process_id=p.id) ind_count,
    (SELECT COUNT(*) FROM process_risks r WHERE r.process_id=p.id AND r.status!='chiuso') risk_count
    FROM processes p LEFT JOIN users u ON u.id=p.owner_id WHERE p.company_id=? ORDER BY CASE p.type WHEN 'direzione' THEN 1 WHEN 'primario' THEN 2 ELSE 3 END, p.code", [$cid]);

$groups = ['direzione'=>[], 'primario'=>[], 'supporto'=>[]];
foreach ($processes as $p) $groups[$p['type']][] = $p;
$groupLabel = ['direzione'=>'Processi di direzione','primario'=>'Processi primari','supporto'=>'Processi di supporto'];

$add = add_panel_open('Nuovo processo', 'save_process');
$add .= '<div class="form-grid">';
$add .= field_input('name','Nome processo','','text','Es. Produzione', true);
$add .= field_input('code','Codice','','text','Es. PRO-09');
$add .= field_select('type','Tipo', ['direzione'=>'Direzione','primario'=>'Primario','supporto'=>'Supporto'], 'primario');
$add .= '<label class="field"><span>Responsabile</span><select class="input" name="owner_id">'.users_options().'</select></label>';
$add .= '</div>';
$add .= field_textarea('purpose','Scopo','','Finalità del processo');
$add .= '<div class="form-grid">'.field_input('inputs','Input','','text','Elementi in ingresso').field_input('outputs','Output','','text','Elementi in uscita').'</div>';
$add .= add_panel_close('Crea processo');

layout_start('Processi', 'processes', 'Mappa dei processi, indicatori e rischi', user_can_write() ? $add : '');
?>
<?php foreach ($groups as $type => $list): if (!$list) continue; ?>
  <section class="proc-group">
    <h2 class="sec-title"><?= e($groupLabel[$type]) ?></h2>
    <div class="card-grid">
      <?php foreach ($list as $p): ?>
        <a class="proc-card card type-<?= e($p['type']) ?>" href="index.php?page=process_detail&id=<?= $p['id'] ?>">
          <div class="proc-card-top"><span class="mono"><?= e($p['code']) ?></span><?= badge(process_type_label($p['type']),'neutral') ?></div>
          <h3><?= e($p['name']) ?></h3>
          <p class="muted"><?= e($p['purpose'] ?: '—') ?></p>
          <div class="proc-card-foot">
            <span><?= icon('people',14) ?> <?= e($p['owner_name'] ?: '—') ?></span>
            <span><?= icon('gauge',14) ?> <?= (int)$p['ind_count'] ?> KPI</span>
            <?php if ($p['risk_count']): ?><span class="tone-warning"><?= icon('alert',14) ?> <?= (int)$p['risk_count'] ?> rischi</span><?php endif; ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>
<?php endforeach; ?>
<?php layout_end(); ?>
