<?php
/* ============================================================
 * QualiFlow PMI — front controller
 * Avvio: php -S localhost:8000 -t public
 * ============================================================ */

require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/auth.php';
require __DIR__ . '/../app/csrf.php';
require __DIR__ . '/../app/mailer.php';
require __DIR__ . '/../app/ui.php';

date_default_timezone_set(config()['timezone'] ?? 'Europe/Rome');
start_secure_session();

// Verifica presenza database
try {
    db()->query('SELECT 1 FROM companies LIMIT 1');
} catch (Throwable $e) {
    http_response_code(500);
    echo '<div style="font-family:system-ui;max-width:640px;margin:80px auto;padding:24px;border:1px solid #e5e7eb;border-radius:12px">';
    echo '<h2 style="margin:0 0 8px">Database non inizializzato</h2>';
    echo '<p>Esegui il comando di setup prima di usare Gestiva:</p>';
    echo '<pre style="background:#0f1729;color:#e2e8f0;padding:14px;border-radius:8px">php scripts/init_db.php --fresh</pre>';
    echo '<p style="color:#64748b">Dettaglio: ' . e($e->getMessage()) . '</p></div>';
    exit;
}

$page = $_GET['page'] ?? 'dashboard';

// Gestione POST centralizzata
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/../app/actions.php';
    handle_action($_POST['action'] ?? '');
    exit;
}

// Logout
if ($page === 'logout') {
    logout();
    redirect_to('login');
}

// Login (unica pagina pubblica)
if ($page === 'login') {
    if (current_user()) redirect_to('dashboard');
    require __DIR__ . '/../app/views/login.php';
    exit;
}

// Da qui in poi serve autenticazione
if (!current_user()) {
    redirect_to('login');
}

$routes = [
    'dashboard'      => 'dashboard.php',
    'audits'         => 'audits.php',
    'audit_detail'   => 'audit_detail.php',
    'nc'             => 'nc.php',
    'nc_detail'      => 'nc_detail.php',
    'checklists'     => 'checklists.php',
    'checklist_run'  => 'checklist_run.php',
    'processes'      => 'processes.php',
    'process_detail' => 'process_detail.php',
    'requirements'   => 'requirements.php',
    'documents'      => 'documents.php',
    'machines'       => 'machines.php',
    'training'       => 'training.php',
    'calendar'       => 'calendar.php',
    'partners'       => 'partners.php',
    'settings'       => 'settings.php',
    'logs'           => 'logs.php',
];

$view = $routes[$page] ?? null;
if ($view === null) {
    http_response_code(404);
    layout_start('Pagina non trovata', 'dashboard');
    empty_state('La pagina richiesta non esiste. Torna al cruscotto.', 'alert');
    layout_end();
    exit;
}

require __DIR__ . '/../app/views/' . $view;
