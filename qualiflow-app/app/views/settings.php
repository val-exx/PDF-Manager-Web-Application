<?php
$cid = current_company_id();
$co = current_company();
$users = all_rows("SELECT * FROM users WHERE company_id=? ORDER BY role, name", [$cid]);
$roleLabel = ['admin'=>'Amministratore (RGQ)','quality_manager'=>'Responsabile qualità','operator'=>'Operatore','viewer'=>'Sola lettura'];

layout_start('Impostazioni', 'settings', 'Dati azienda, utenti e configurazione');
?>
<div class="grid-2">
  <div class="card">
    <?php section_title('Dati azienda', is_admin()?'Modificabili dall\'amministratore':'Sola lettura'); ?>
    <?php if (is_admin()): ?>
    <form method="post">
      <?= csrf_field() ?><input type="hidden" name="action" value="save_company">
      <div class="form-grid">
        <?= field_input('name','Ragione sociale', $co['name'] ?? '', 'text','',true) ?>
        <?= field_input('vat_number','P. IVA', $co['vat_number'] ?? '') ?>
        <?= field_input('city','Città', $co['city'] ?? '') ?>
        <?= field_input('sector','Settore', $co['sector'] ?? '') ?>
        <?= field_input('standards','Standard', $co['standards'] ?? '', 'text','ISO 9001:2015, IATF 16949:2016') ?>
        <?= field_input('cert_body','Ente di certificazione', $co['cert_body'] ?? '') ?>
        <?= field_date('next_audit_date','Prossimo audit ente', $co['next_audit_date'] ?? '') ?>
      </div>
      <?= field_input('address','Indirizzo', $co['address'] ?? '') ?>
      <button class="btn btn-primary" type="submit">Salva modifiche</button>
    </form>
    <?php else: ?>
      <div class="detail-grid">
        <div><span class="dl">Ragione sociale</span><span class="dv"><?= e($co['name']) ?></span></div>
        <div><span class="dl">P. IVA</span><span class="dv"><?= e($co['vat_number'] ?: '—') ?></span></div>
        <div><span class="dl">Città</span><span class="dv"><?= e($co['city'] ?: '—') ?></span></div>
        <div><span class="dl">Standard</span><span class="dv"><?= e($co['standards'] ?: '—') ?></span></div>
        <div><span class="dl">Ente</span><span class="dv"><?= e($co['cert_body'] ?: '—') ?></span></div>
        <div><span class="dl">Prossimo audit</span><span class="dv"><?= date_it($co['next_audit_date']) ?></span></div>
      </div>
    <?php endif; ?>
  </div>

  <div class="card">
    <?php section_title('Utenti', count($users).' account'); ?>
    <ul class="user-list">
      <?php foreach ($users as $u): ?>
        <li>
          <?= avatar($u['name']) ?>
          <div class="user-info"><strong><?= e($u['name']) ?></strong><small><?= e($u['email']) ?></small></div>
          <?= badge($roleLabel[$u['role']] ?? $u['role'], $u['role']==='admin'?'primary':($u['role']==='viewer'?'muted':'neutral')) ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="info-box">
      <?= icon('shield',18) ?>
      <div><strong>Ruoli e permessi.</strong> Amministratore e Responsabile qualità possono creare e modificare. Operatore registra attività. Sola lettura consulta soltanto.</div>
    </div>
  </div>
</div>

<div class="card">
  <?php section_title('Informazioni demo', 'Ambiente dimostrativo'); ?>
  <div class="info-box">
    <?= icon('alert',18) ?>
    <div><strong>Questa è una demo con dati di esempio.</strong> Tutte le password sono <code>password</code>. Le email vengono scritte su file di log invece di essere inviate. I dati possono essere rigenerati con <code>php scripts/init_db.php --fresh</code>.</div>
  </div>
</div>
<?php layout_end(); ?>
