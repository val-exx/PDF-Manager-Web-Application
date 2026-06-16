<?php
/* ============================================================
 * Helpers Gestiva: escape, date, label/tone normativi, upload, log
 * ============================================================ */

/* Polyfill leggeri per ambienti privi dell'estensione mbstring.
   In produzione si consiglia di abilitare php-mbstring. */
if (!function_exists('mb_substr')) {
    function mb_substr($s, $start, $length = null, $enc = null) {
        $s = (string)$s;
        if (preg_match_all('/./us', $s, $m) === false) {
            return $length === null ? substr($s, $start) : substr($s, $start, $length);
        }
        $chars = $m[0];
        $slice = $length === null ? array_slice($chars, $start) : array_slice($chars, $start, $length);
        return implode('', $slice);
    }
}
if (!function_exists('mb_strlen')) {
    function mb_strlen($s, $enc = null) {
        return preg_match_all('/./us', (string)$s, $m) ?: 0;
    }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($s, $enc = null) {
        return strtoupper((string)$s);
    }
}

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect_to(string $page, array $params = []): never
{
    $query = array_merge(['page' => $page], $params);
    header('Location: index.php?' . http_build_query($query));
    exit;
}

function flash(?string $message = null, string $type = 'success'): ?array
{
    if ($message !== null) {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
        return null;
    }
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function current_company_id(): int
{
    return (int)(current_user()['company_id'] ?? 1);
}

function current_company(): array
{
    return one('SELECT * FROM companies WHERE id = ?', [current_company_id()]) ?? [];
}

function is_admin(): bool
{
    return (current_user()['role'] ?? '') === 'admin';
}

function user_can_write(): bool
{
    return in_array(current_user()['role'] ?? 'viewer', ['admin', 'quality_manager', 'operator'], true);
}

function require_write(): void
{
    if (!user_can_write()) {
        flash('Permesso negato: utente in sola lettura.', 'error');
        redirect_to('dashboard');
    }
}

/* ----------------------- DATE ----------------------- */
function date_it(?string $date): string
{
    if (!$date) return '-';
    try { return (new DateTime($date))->format('d/m/Y'); }
    catch (Exception $e) { return e($date); }
}

function datetime_it(?string $date): string
{
    if (!$date) return '-';
    try { return (new DateTime($date))->format('d/m/Y H:i'); }
    catch (Exception $e) { return e($date); }
}

/** Giorni mancanti alla data (negativo = scaduta). null se data assente. */
function days_until(?string $date): ?int
{
    if (!$date) return null;
    try {
        $today = new DateTime('today');
        $d = new DateTime((new DateTime($date))->format('Y-m-d'));
        return (int)$today->diff($d)->format('%r%a');
    } catch (Exception $e) { return null; }
}

/** Tono in base alla vicinanza della scadenza. */
function due_tone(?string $date, int $warnDays = 14): string
{
    $d = days_until($date);
    if ($d === null) return 'neutral';
    if ($d < 0) return 'danger';
    if ($d <= $warnDays) return 'warning';
    return 'success';
}

function due_label(?string $date): string
{
    $d = days_until($date);
    if ($d === null) return 'senza scadenza';
    if ($d < 0) return abs($d) . ' gg in ritardo';
    if ($d === 0) return 'oggi';
    if ($d === 1) return 'domani';
    return 'tra ' . $d . ' gg';
}

function it_num($n, int $dec = 0): string
{
    return number_format((float)$n, $dec, ',', '.');
}

/* ----------------------- BADGE ----------------------- */
function badge(string $text, string $tone = 'neutral', ?string $dot = null): string
{
    $d = $dot !== null ? '<i class="dot"></i>' : '';
    return '<span class="badge badge-' . e($tone) . '">' . $d . e($text) . '</span>';
}

/* ----------------------- LABEL & TONE NORMATIVI ----------------------- */
function priority_tone(string $p): string
{
    return match ($p) {
        'critica' => 'danger', 'alta' => 'warning', 'media' => 'neutral', 'bassa' => 'muted',
        default => 'neutral',
    };
}

function severity_tone(string $s): string
{
    return match ($s) {
        'critica' => 'danger', 'alta' => 'warning', 'media' => 'neutral', 'bassa' => 'muted',
        default => 'neutral',
    };
}

function activity_status_label(string $s): string
{
    return match ($s) {
        'aperta' => 'Aperta', 'in_lavorazione' => 'In lavorazione', 'completata' => 'Completata',
        'scaduta' => 'Scaduta', 'annullata' => 'Annullata', default => ucfirst($s),
    };
}

function activity_status_tone(string $s): string
{
    return match ($s) {
        'completata' => 'success', 'in_lavorazione' => 'warning', 'scaduta' => 'danger',
        'annullata' => 'muted', default => 'neutral',
    };
}

function activity_type_label(string $type): string
{
    return match ($type) {
        'riesame_direzione' => 'Riesame direzione', 'manutenzione' => 'Manutenzione',
        'formazione' => 'Formazione', 'taratura' => 'Taratura', 'disaster_recovery' => 'Disaster recovery',
        'documento' => 'Documento', 'audit' => 'Audit', 'riunione' => 'Riunione',
        'azione_correttiva' => 'Azione correttiva', 'fornitore' => 'Fornitore',
        default => ucfirst(str_replace('_', ' ', $type)),
    };
}

function nc_source_label(string $s): string
{
    return match ($s) {
        'interna' => 'Interna', 'cliente' => 'Cliente', 'fornitore' => 'Fornitore',
        'audit' => 'Da audit', 'processo' => 'Di processo', 'reclamo' => 'Reclamo cliente',
        default => ucfirst($s),
    };
}

function nc_status_label(string $s): string
{
    return match ($s) {
        'aperta' => 'Aperta', 'contenimento' => 'Contenimento', 'analisi' => 'Analisi cause',
        'azioni' => 'Azioni in corso', 'verifica' => 'Verifica efficacia', 'chiusa' => 'Chiusa',
        default => ucfirst($s),
    };
}

function nc_status_tone(string $s): string
{
    return match ($s) {
        'chiusa' => 'success', 'verifica' => 'warning', 'azioni' => 'warning',
        'aperta', 'contenimento', 'analisi' => 'danger', default => 'neutral',
    };
}

function audit_type_label(string $t): string
{
    return match ($t) {
        'interno' => 'Interno', 'esterno_ente' => 'Esterno / Ente', 'fornitore' => 'Fornitore',
        'cliente' => 'Cliente', default => ucfirst($t),
    };
}

function audit_status_label(string $s): string
{
    return match ($s) {
        'pianificato' => 'Pianificato', 'in_corso' => 'In corso', 'rilievi' => 'Rilievi',
        'follow_up' => 'Follow-up', 'chiuso' => 'Chiuso', default => ucfirst($s),
    };
}

function audit_status_tone(string $s): string
{
    return match ($s) {
        'chiuso' => 'success', 'follow_up' => 'warning', 'rilievi' => 'warning',
        'in_corso' => 'neutral', 'pianificato' => 'muted', default => 'neutral',
    };
}

function finding_type_label(string $t): string
{
    return match ($t) {
        'nc_maggiore' => 'NC maggiore', 'nc_minore' => 'NC minore', 'osservazione' => 'Osservazione',
        'opportunita' => 'Opportunità', 'punto_forza' => 'Punto di forza', default => ucfirst($t),
    };
}

function finding_type_tone(string $t): string
{
    return match ($t) {
        'nc_maggiore' => 'danger', 'nc_minore' => 'warning', 'osservazione' => 'neutral',
        'opportunita' => 'info', 'punto_forza' => 'success', default => 'neutral',
    };
}

function answer_label(string $a): string
{
    return match ($a) {
        'conforme' => 'Conforme', 'non_conforme' => 'Non conforme', 'osservazione' => 'Osservazione',
        'na' => 'N/A', 'da_valutare' => 'Da valutare', default => ucfirst($a),
    };
}

function answer_tone(string $a): string
{
    return match ($a) {
        'conforme' => 'success', 'non_conforme' => 'danger', 'osservazione' => 'warning',
        'na' => 'muted', default => 'neutral',
    };
}

function doc_status_label(string $s): string
{
    return match ($s) {
        'bozza' => 'Bozza', 'in_revisione' => 'In revisione', 'approvato' => 'Approvato',
        'obsoleto' => 'Obsoleto', 'scaduto' => 'Scaduto', default => ucfirst($s),
    };
}

function doc_status_tone(string $s): string
{
    return match ($s) {
        'approvato' => 'success', 'in_revisione' => 'warning', 'bozza' => 'neutral',
        'obsoleto' => 'muted', 'scaduto' => 'danger', default => 'neutral',
    };
}

function instrument_status_tone(string $s): string
{
    return match ($s) {
        'idoneo' => 'success', 'in_scadenza' => 'warning', 'scaduto' => 'danger',
        'fuori_uso' => 'muted', default => 'neutral',
    };
}

function partner_status_tone(string $s): string
{
    return match ($s) {
        'approvato' => 'success', 'in_valutazione' => 'neutral', 'condizionato' => 'warning',
        'sospeso' => 'danger', default => 'neutral',
    };
}

function machine_status_tone(string $s): string
{
    return match ($s) {
        'attiva' => 'success', 'ferma' => 'danger', 'dismessa' => 'muted', default => 'neutral',
    };
}

function process_type_label(string $t): string
{
    return match ($t) {
        'direzione' => 'Direzione', 'primario' => 'Primario', 'supporto' => 'Supporto', default => ucfirst($t),
    };
}

function nav_active(string $page, string $current): string
{
    return $page === $current ? 'active' : '';
}

/* ----------------------- UPLOAD ----------------------- */
function safe_filename(string $name): string
{
    $name = preg_replace('/[^A-Za-z0-9._-]+/', '-', $name);
    $name = trim($name, '.-');
    return $name !== '' ? $name : 'file';
}

function save_uploaded_file(string $field): ?string
{
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Errore upload file.');
    }
    $cfg = config()['uploads'];
    if ($file['size'] > (int)$cfg['max_mb'] * 1024 * 1024) {
        throw new RuntimeException('File troppo grande. Massimo ' . (int)$cfg['max_mb'] . ' MB.');
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $cfg['allowed_extensions'], true)) {
        throw new RuntimeException('Estensione non consentita.');
    }
    if (!is_dir($cfg['dir'])) mkdir($cfg['dir'], 0775, true);
    $filename = date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '-' . safe_filename($file['name']);
    $target = rtrim($cfg['dir'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Impossibile salvare il file.');
    }
    return $cfg['url_prefix'] . '/' . $filename;
}

function log_activity(string $action, ?string $subjectType = null, ?int $subjectId = null, ?string $description = null): void
{
    try {
        q('INSERT INTO activity_logs (company_id, user_id, action, subject_type, subject_id, description, created_at) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)', [
            current_company_id(), current_user()['id'] ?? null, $action, $subjectType, $subjectId, $description,
        ]);
    } catch (Throwable $e) { /* non bloccante */ }
}

/** Prossimo codice progressivo tipo PREFIX-YYYY-NNN per una tabella. */
function next_code(string $table, string $prefix): string
{
    $year = date('Y');
    $like = $prefix . '-' . $year . '-%';
    $row = one("SELECT code FROM {$table} WHERE company_id = ? AND code LIKE ? ORDER BY id DESC LIMIT 1", [current_company_id(), $like]);
    $n = 1;
    if ($row && preg_match('/(\d+)$/', $row['code'], $m)) {
        $n = (int)$m[1] + 1;
    }
    return sprintf('%s-%s-%03d', $prefix, $year, $n);
}
