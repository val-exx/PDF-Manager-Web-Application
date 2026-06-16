<?php
/* ============================================================
 * Gestiva — inizializzazione database
 * Uso:
 *   php scripts/init_db.php           crea il DB se non esiste
 *   php scripts/init_db.php --fresh   ricrea da zero (drop + schema + seed)
 * ============================================================ */

require __DIR__ . '/../app/db.php';

$fresh = in_array('--fresh', $argv, true);
$cfg = config()['db'];

if ($cfg['driver'] !== 'sqlite') {
    fwrite(STDERR, "Questo script è pensato per SQLite (demo). Per MySQL importa database/schema.mysql.sql e database/seed.mysql.sql.\n");
    exit(1);
}

$path = $cfg['sqlite_path'];
$dir = dirname($path);
if (!is_dir($dir)) mkdir($dir, 0775, true);

if ($fresh && file_exists($path)) {
    unlink($path);
    echo "• Database precedente rimosso.\n";
}

$pdo = db();
$pdo->exec('PRAGMA foreign_keys = ON');

function run_sql_file(PDO $pdo, string $file): void
{
    if (!file_exists($file)) {
        fwrite(STDERR, "File non trovato: $file\n");
        exit(1);
    }
    $sql = file_get_contents($file);
    $pdo->exec($sql);
    echo "• Eseguito " . basename($file) . "\n";
}

$base = __DIR__ . '/../database';

// Schema (idempotente: usa IF NOT EXISTS)
run_sql_file($pdo, $base . '/schema.sqlite.sql');

// Seed solo se vuoto o --fresh
$hasData = (int)$pdo->query("SELECT COUNT(*) FROM companies")->fetchColumn();
if ($fresh || $hasData === 0) {
    run_sql_file($pdo, $base . '/seed.sqlite.sql');
    echo "• Dati demo caricati.\n";
} else {
    echo "• Dati già presenti: seed saltato (usa --fresh per ricaricare).\n";
}

echo "\n✓ Database pronto: $path\n";
echo "  Avvia il server:  php -S localhost:8000 -t public\n";
echo "  Accedi con:       admin@gestiva.local / password\n";
