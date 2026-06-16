<?php
/**
 * Configurazione Gestiva.
 *
 * DEMO: usa SQLite, nessun utente/password DB da configurare.
 * PRODUZIONE: sostituisci il blocco 'db' con MySQL/PostgreSQL.
 */
return [
    'app_name'  => 'QualiFlow PMI',
    'app_claim' => 'Il sistema qualità della tua PMI, sotto controllo.',
    'timezone'  => 'Europe/Rome',

    // Imposta false in produzione.
    'demo_mode' => true,

    'db' => [
        'driver'      => 'sqlite',
        'sqlite_path' => __DIR__ . '/../storage/gestiva.sqlite',

        /*
         * ESEMPIO FUTURO MYSQL - NON USATO NELLA DEMO
         * 'driver'   => 'mysql',
         * 'host'     => '127.0.0.1',
         * 'port'     => '3306',
         * 'database' => 'gestiva',
         * 'username' => 'gestiva_user',
         * 'password' => 'INSERISCI_PASSWORD_FORTE_QUI',
         * 'charset'  => 'utf8mb4',
         */
    ],

    'security' => [
        'session_name'            => 'gestiva_session',
        'session_lifetime_minutes' => 120,
    ],

    'uploads' => [
        'dir'                => __DIR__ . '/../public/uploads',
        'url_prefix'         => 'uploads',
        'max_mb'             => 8,
        'allowed_extensions' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'png', 'jpg', 'jpeg', 'txt', 'dxf', 'dwg'],
    ],

    'mail' => [
        // DEMO: scrive le email in storage/mail.log.
        'mode'     => 'log',
        'from'     => 'no-reply@gestiva.local',
        'log_file' => __DIR__ . '/../storage/mail.log',

        /*
         * ESEMPIO FUTURO SMTP - NON USATO NELLA DEMO
         * 'mode'       => 'smtp',
         * 'host'       => 'smtp.tuodominio.it',
         * 'port'       => 587,
         * 'username'   => 'smtp_user',
         * 'password'   => 'INSERISCI_PASSWORD_SMTP_QUI',
         * 'encryption' => 'tls',
         */
    ],
];
