<?php
$cid = current_company_id();
$reqs = all_rows("SELECT * FROM requirements ORDER BY standard, clause_code");
$byStd = [];
foreach ($reqs as $r) $byStd[$r['standard']][] = $r;

layout_start('Requisiti', 'requirements', 'Mappa dei requisiti ISO 9001 e IATF 16949');
?>
<p class="page-intro">Riferimenti sintetici alle clausole delle norme con categoria, frequenza ed evidenze tipiche. Il testo integrale delle norme non è riprodotto: consulta le edizioni ufficiali.</p>

<?php foreach ($byStd as $std => $list): ?>
<div class="card">
  <?php section_title($std, count($list) . ' requisiti mappati'); ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Clausola</th><th>Titolo</th><th>Categoria</th><th>Frequenza</th><th>Evidenza tipica</th></tr></thead>
      <tbody>
        <?php foreach ($list as $r): ?>
          <tr>
            <td><span class="mono"><?= e($r['clause_code']) ?></span></td>
            <td><strong><?= e($r['title']) ?></strong><?php if($r['description_short']):?><small class="sub"><?= e($r['description_short']) ?></small><?php endif;?></td>
            <td><?= badge($r['category'],'neutral') ?></td>
            <td><?= e($r['default_frequency'] ?: '—') ?></td>
            <td class="muted"><?= e($r['default_evidence'] ?: '—') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endforeach; ?>
<?php layout_end(); ?>
