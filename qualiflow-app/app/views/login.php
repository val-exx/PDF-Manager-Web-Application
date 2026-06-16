<?php $f = flash(); ?><!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Accedi · QualiFlow PMI</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/app.css?v=2">
  <link rel="icon" href="assets/logo.svg">
</head>
<body class="login-body">
  <div class="login-wrap">
    <section class="login-aside">
      <div class="login-brand"><?= icon('shield', 26) ?> <span>QualiFlow PMI</span></div>
      <h1 class="login-h">Il sistema qualità della tua PMI, sotto controllo.</h1>
      <p class="login-sub">Audit interni ed esterni, non conformità con metodo 8D, processi, documentazione, manutenzione e formazione. Pensato per le PMI dell'automotive — conforme a ISO 9001 e IATF 16949.</p>
      <ul class="login-points">
        <li><?= icon('gauge', 18) ?> Indice di prontezza audit in tempo reale</li>
        <li><?= icon('nc', 18) ?> Gestione non conformità interne ed esterne (8D)</li>
        <li><?= icon('audit', 18) ?> Audit, checklist e rilievi in un unico flusso</li>
        <li><?= icon('process', 18) ?> Processi, indicatori e rischi sempre aggiornati</li>
      </ul>
      <div class="login-foot">Demo dimostrativa · dati di esempio</div>
    </section>

    <section class="login-form-side">
      <div class="login-card">
        <h2>Accedi</h2>
        <p class="muted">Entra nel cruscotto qualità.</p>
        <?php if ($f): ?><div class="flash flash-<?= e($f['type']) ?>"><?= icon($f['type'] === 'error' ? 'alert' : 'check', 18) ?><span><?= e($f['message']) ?></span></div><?php endif; ?>
        <form method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="login">
          <label class="field"><span>Email</span>
            <input class="input" type="email" name="email" value="admin@gestiva.local" required autofocus>
          </label>
          <label class="field"><span>Password</span>
            <input class="input" type="password" name="password" value="password" required>
          </label>
          <button class="btn btn-primary btn-block" type="submit">Accedi al cruscotto</button>
        </form>
        <div class="login-demo">
          <strong>Accessi demo</strong>
          <table>
            <tr><td>RGQ (admin)</td><td>admin@gestiva.local</td></tr>
            <tr><td>Quality</td><td>marco@gestiva.local</td></tr>
            <tr><td>Produzione</td><td>luca@gestiva.local</td></tr>
            <tr><td>Direzione (sola lettura)</td><td>direzione@gestiva.local</td></tr>
          </table>
          <small>Password per tutti: <code>password</code></small>
        </div>
      </div>
    </section>
  </div>
  <script src="assets/app.js?v=2"></script>
</body>
</html>
