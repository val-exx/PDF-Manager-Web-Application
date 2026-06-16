<?php
/* ============================================================
 * Gestiva — promemoria scadenze (da eseguire via cron)
 * Esempio crontab (ogni giorno alle 7:00):
 *   0 7 * * * php /percorso/gestiva/scripts/cron_reminders.php
 *
 * In demo le email vengono scritte su storage/mail.log.
 * ============================================================ */

require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/mailer.php';

date_default_timezone_set(config()['timezone'] ?? 'Europe/Rome');

$today = date('Y-m-d');
$horizon = date('Y-m-d', strtotime('+14 day'));
$sent = 0;

$companies = all_rows("SELECT id, name FROM companies");
foreach ($companies as $co) {
    $cid = (int)$co['id'];
    $lines = [];

    foreach (all_rows("SELECT title, due_date FROM activities WHERE company_id=? AND status NOT IN ('completata','annullata') AND due_date IS NOT NULL AND due_date <= ? ORDER BY due_date", [$cid, $horizon]) as $a) {
        $lines[] = sprintf("[Attività]  %s — scadenza %s", $a['title'], $a['due_date']);
    }
    foreach (all_rows("SELECT code, name, next_calibration FROM instruments WHERE company_id=? AND next_calibration IS NOT NULL AND next_calibration <= ? AND status!='idoneo' ORDER BY next_calibration", [$cid, $horizon]) as $i) {
        $lines[] = sprintf("[Taratura]  %s %s — scadenza %s", $i['code'], $i['name'], $i['next_calibration']);
    }
    foreach (all_rows("SELECT code, title, due_date FROM non_conformities WHERE company_id=? AND status!='chiusa' AND due_date IS NOT NULL AND due_date <= ? ORDER BY due_date", [$cid, $horizon]) as $n) {
        $lines[] = sprintf("[NC]        %s %s — scadenza %s", $n['code'], $n['title'], $n['due_date']);
    }

    if (!$lines) continue;

    $admins = all_rows("SELECT email, name FROM users WHERE company_id=? AND role IN ('admin','quality_manager') AND active=1", [$cid]);
    $body = "Promemoria scadenze qualità — " . $co['name'] . "\n\n" . implode("\n", $lines) . "\n\n— Gestiva";
    foreach ($admins as $u) {
        send_demo_mail($u['email'], "Gestiva · scadenze in arrivo (" . count($lines) . ")", $body);
        queue_mail($cid, null, $u['email'], "Gestiva · scadenze in arrivo (" . count($lines) . ")", $body);
        $sent++;
    }
    echo "• {$co['name']}: " . count($lines) . " scadenze, " . count($admins) . " destinatari\n";
}

echo "\n✓ Promemoria elaborati. Email generate: $sent\n";
