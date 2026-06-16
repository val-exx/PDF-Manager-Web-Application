<?php
function queue_mail(int $companyId, ?int $userId, string $to, string $subject, string $body): void
{
    q('INSERT INTO mail_queue (company_id, user_id, recipient, subject, body, status, created_at) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)', [
        $companyId,
        $userId,
        $to,
        $subject,
        $body,
        'queued',
    ]);
}

function send_demo_mail(string $to, string $subject, string $body): void
{
    $cfg = config()['mail'];
    if ($cfg['mode'] === 'log') {
        $line = "\n--- " . date('Y-m-d H:i:s') . " ---\nTO: {$to}\nSUBJECT: {$subject}\n{$body}\n";
        file_put_contents($cfg['log_file'], $line, FILE_APPEND);
        return;
    }

    // In produzione sostituire con SMTP/API transazionale.
    // mail($to, $subject, $body, 'From: ' . $cfg['from']);
}
