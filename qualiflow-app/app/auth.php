<?php
function start_secure_session(): void
{
    $cfg = config()['security'];
    session_name($cfg['session_name']);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function current_user(): ?array
{
    static $user = null;
    if ($user !== null) {
        return $user;
    }
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    $user = one('SELECT users.*, companies.name AS company_name FROM users LEFT JOIN companies ON companies.id = users.company_id WHERE users.id = ?', [(int)$_SESSION['user_id']]);
    return $user ?: null;
}

function require_login(): void
{
    if (!current_user()) {
        header('Location: index.php?page=login');
        exit;
    }
}

function attempt_login(string $email, string $password): bool
{
    $user = one('SELECT * FROM users WHERE email = ? AND active = 1 LIMIT 1', [strtolower(trim($email))]);
    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];
    q('UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = ?', [(int)$user['id']]);
    return true;
}

function logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
    }
    session_destroy();
}
