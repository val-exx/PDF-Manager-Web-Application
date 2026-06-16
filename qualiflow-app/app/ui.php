<?php
/* ============================================================
 * QualiFlow PMI UI kit — layout, navigazione, componenti, grafici SVG
 * Nessuna dipendenza esterna. Animazioni via CSS (rispettano
 * prefers-reduced-motion). I grafici sono SVG generati lato server.
 * ============================================================ */

/* ----------------------- ICONE (line, stroke currentColor) ----------------------- */
function icon(string $name, int $size = 20): string
{
    $paths = [
        'dashboard'   => '<rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>',
        'audit'       => '<path d="M9 11l2.5 2.5L16 8"/><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 3v3h8V3"/>',
        'nc'          => '<path d="M12 9v4M12 17h.01"/><path d="M10.3 4.3 2.6 18a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 4.3a2 2 0 0 0-3.4 0Z"/>',
        'checklist'   => '<path d="M9 6h11M9 12h11M9 18h11"/><path d="m3.5 6 1 1 1.5-2M3.5 12l1 1 1.5-2M3.5 18l1 1 1.5-2"/>',
        'process'     => '<circle cx="6" cy="6" r="2.5"/><circle cx="18" cy="6" r="2.5"/><circle cx="12" cy="18" r="2.5"/><path d="M8.5 6H15.5M6 8.5V13a2 2 0 0 0 2 2h2M18 8.5V13a2 2 0 0 1-2 2h-2"/>',
        'requirement' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h4"/>',
        'document'    => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/>',
        'machine'     => '<path d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z"/><path d="M19 12a7 7 0 0 0-.1-1.2l2-1.6-2-3.4-2.4 1a7 7 0 0 0-2-1.2L14 2h-4l-.5 2.6a7 7 0 0 0-2 1.2l-2.4-1-2 3.4 2 1.6A7 7 0 0 0 5 12c0 .4 0 .8.1 1.2l-2 1.6 2 3.4 2.4-1a7 7 0 0 0 2 1.2L10 22h4l.5-2.6a7 7 0 0 0 2-1.2l2.4 1 2-3.4-2-1.6c.1-.4.1-.8.1-1.2Z"/>',
        'training'    => '<path d="M22 9 12 5 2 9l10 4 10-4Z"/><path d="M6 11v5c0 1.1 2.7 3 6 3s6-1.9 6-3v-5"/>',
        'calendar'    => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'partner'     => '<path d="M3 21V7l6-4 6 4v14"/><path d="M15 21V11l6 4v6"/><path d="M7 9h.01M7 13h.01M7 17h.01"/>',
        'people'      => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><path d="M16 5.5a3 3 0 0 1 0 5.8M21 20a6 6 0 0 0-4-5.6"/>',
        'settings'    => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.6 1.6 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.6 1.6 0 0 0-1.8-.3 1.6 1.6 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.6 1.6 0 0 0-1-1.5 1.6 1.6 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.6 1.6 0 0 0 .3-1.8 1.6 1.6 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.6 1.6 0 0 0 1.5-1 1.6 1.6 0 0 0-.3-1.8l-.1-.1A2 2 0 1 1 7 4.6l.1.1a1.6 1.6 0 0 0 1.8.3H9a1.6 1.6 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.6 1.6 0 0 0 1 1.5 1.6 1.6 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.6 1.6 0 0 0-.3 1.8V9a1.6 1.6 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.6 1.6 0 0 0-1.5 1Z"/>',
        'log'         => '<path d="M12 8v4l3 2"/><circle cx="12" cy="12" r="9"/>',
        'logout'      => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>',
        'search'      => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
        'plus'        => '<path d="M12 5v14M5 12h14"/>',
        'check'       => '<path d="M20 6 9 17l-5-5"/>',
        'clock'       => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'gauge'       => '<path d="M12 14 8 9"/><circle cx="12" cy="12" r="1.6"/><path d="M3.5 17a9 9 0 1 1 17 0"/>',
        'alert'       => '<circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/>',
        'chevron'     => '<path d="m9 6 6 6-6 6"/>',
        'arrow-up'    => '<path d="M12 19V5M5 12l7-7 7 7"/>',
        'arrow-down'  => '<path d="M12 5v14M19 12l-7 7-7-7"/>',
        'building'    => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 8h.01M15 8h.01M9 12h.01M15 12h.01M10 21v-3h4v3"/>',
        'shield'      => '<path d="M12 3 5 6v5c0 4.5 3 7.5 7 9 4-1.5 7-4.5 7-9V6z"/><path d="m9 12 2 2 4-4"/>',
        'flag'        => '<path d="M4 22V4M4 4h12l-2 4 2 4H4"/>',
        'bell'        => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/>',
        'menu'        => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'wrench'      => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.5 2.5-2.5-.5-.5-2.5z"/>',
    ];
    $p = $paths[$name] ?? '<circle cx="12" cy="12" r="9"/>';
    return '<svg class="ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
}

/* ----------------------- NAVIGAZIONE ----------------------- */
function nav_groups(): array
{
    return [
        'Cruscotto' => [
            ['dashboard', 'dashboard', 'Cruscotto'],
        ],
        'Qualità' => [
            ['audits', 'audit', 'Audit'],
            ['nc', 'nc', 'Non conformità'],
            ['checklists', 'checklist', 'Checklist'],
            ['processes', 'process', 'Processi'],
            ['requirements', 'requirement', 'Requisiti'],
        ],
        'Operations' => [
            ['documents', 'document', 'Documenti & Manuali'],
            ['machines', 'machine', 'Manutenzione'],
            ['training', 'training', 'Formazione'],
            ['calendar', 'calendar', 'Scadenzario'],
        ],
        'Anagrafiche' => [
            ['partners', 'partner', 'Clienti & Fornitori'],
        ],
        'Sistema' => [
            ['settings', 'settings', 'Impostazioni'],
            ['logs', 'log', 'Registro attività'],
        ],
    ];
}

function sidebar(string $current): void
{
    $co = current_company();
    ?>
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <span class="brand-mark"><?= icon('shield', 22) ?></span>
        <span class="brand-text"><strong>QualiFlow PMI</strong><small>Qualità & Audit</small></span>
      </div>
      <nav class="nav">
        <?php foreach (nav_groups() as $group => $items): ?>
          <div class="nav-group"><?= e($group) ?></div>
          <?php foreach ($items as [$page, $ic, $label]): ?>
            <a href="index.php?page=<?= e($page) ?>" class="nav-link <?= nav_active($page, $current) ?>">
              <span class="nav-ic"><?= icon($ic) ?></span><span><?= e($label) ?></span>
            </a>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </nav>
      <div class="sidebar-foot">
        <span class="company-dot"><?= e(strtoupper(mb_substr($co['name'] ?? 'G', 0, 1))) ?></span>
        <span class="company-name"><?= e($co['name'] ?? 'Azienda') ?></span>
      </div>
    </aside>
    <?php
}

/* ----------------------- LAYOUT ----------------------- */
function layout_start(string $title, string $current, string $subtitle = '', string $actions = ''): void
{
    $user = current_user();
    $initials = strtoupper(mb_substr($user['name'] ?? 'U', 0, 1) . (preg_match('/\s(\S)/u', $user['name'] ?? '', $m) ? $m[1] : ''));
    ?><!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?> · QualiFlow PMI</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/app.css?v=2">
  <link rel="icon" href="assets/logo.svg">
</head>
<body>
<div class="app-shell">
  <?php sidebar($current); ?>
  <div class="scrim" id="scrim"></div>
  <main class="main">
    <header class="topbar">
      <button class="icon-btn only-mobile" id="menuBtn" aria-label="Menu"><?= icon('menu') ?></button>
      <div class="topbar-title">
        <h1><?= e($title) ?></h1>
        <?php if ($subtitle): ?><p><?= e($subtitle) ?></p><?php endif; ?>
      </div>
      <div class="topbar-tools">
        <div class="search-box only-desktop"><?= icon('search', 18) ?><input type="search" placeholder="Cerca…" aria-label="Cerca"></div>
        <?php if ($actions): ?><div class="topbar-actions"><?= $actions ?></div><?php endif; ?>
        <div class="user-pill">
          <span class="avatar"><?= e($initials) ?></span>
          <span class="user-meta only-desktop"><strong><?= e($user['name'] ?? '') ?></strong><small><?= e($user['job_title'] ?? '') ?></small></span>
          <a class="icon-btn ghost" href="index.php?page=logout" title="Esci"><?= icon('logout', 18) ?></a>
        </div>
      </div>
    </header>
    <?php if ($f = flash()): ?>
      <div class="flash flash-<?= e($f['type']) ?>"><?= icon($f['type'] === 'error' ? 'alert' : 'check', 18) ?><span><?= e($f['message']) ?></span></div>
    <?php endif; ?>
    <div class="page">
    <?php
}

function layout_end(): void
{
    ?>
    </div>
  </main>
</div>
<script src="assets/app.js?v=2"></script>
</body>
</html>
    <?php
}

/* ----------------------- COMPONENTI ----------------------- */
function section_title(string $title, string $hint = '', string $right = ''): void
{
    echo '<div class="sec-head"><div><h2 class="sec-title">' . e($title) . '</h2>';
    if ($hint) echo '<p class="sec-hint">' . e($hint) . '</p>';
    echo '</div>';
    if ($right) echo '<div class="sec-right">' . $right . '</div>';
    echo '</div>';
}

function empty_state(string $text, string $icon = 'document'): void
{
    echo '<div class="empty">' . icon($icon, 28) . '<p>' . e($text) . '</p></div>';
}

function count_up($to, string $suffix = '', int $dec = 0): string
{
    return '<span class="count" data-to="' . e((string)$to) . '" data-dec="' . $dec . '" data-suffix="' . e($suffix) . '">' . it_num(0, $dec) . e($suffix) . '</span>';
}

/* KPI tile con sparkline opzionale */
function kpi_tile(string $label, $value, string $hint, string $tone = 'neutral', string $iconName = 'gauge', string $suffix = '', ?array $spark = null): void
{
    echo '<div class="kpi kpi-' . e($tone) . '">';
    echo '<div class="kpi-top"><span class="kpi-ic">' . icon($iconName, 18) . '</span><span class="kpi-label">' . e($label) . '</span></div>';
    echo '<div class="kpi-value">' . count_up($value, $suffix) . '</div>';
    if ($spark) echo '<div class="kpi-spark">' . sparkline($spark, $tone) . '</div>';
    echo '<div class="kpi-hint">' . e($hint) . '</div>';
    echo '</div>';
}

/* Anello di progresso (SVG) animato */
function ring($pct, int $size = 132, int $stroke = 12, string $tone = 'primary', ?string $center = null, string $sub = ''): string
{
    $pct = max(0, min(100, (float)$pct));
    $r = ($size - $stroke) / 2;
    $c = 2 * M_PI * $r;
    $off = $c * (1 - $pct / 100);
    $cx = $size / 2;
    $center = $center ?? (round($pct) . '%');
    $h = '<div class="ring" style="width:' . $size . 'px;height:' . $size . 'px">';
    $h .= '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '">';
    $h .= '<circle class="ring-track" cx="' . $cx . '" cy="' . $cx . '" r="' . $r . '" stroke-width="' . $stroke . '" fill="none"/>';
    $h .= '<circle class="ring-value tone-' . e($tone) . '" cx="' . $cx . '" cy="' . $cx . '" r="' . $r . '" stroke-width="' . $stroke . '" fill="none" stroke-linecap="round" transform="rotate(-90 ' . $cx . ' ' . $cx . ')" style="--circ:' . round($c, 2) . ';--off:' . round($off, 2) . '"/>';
    $h .= '</svg><div class="ring-center"><strong>' . $center . '</strong>' . ($sub ? '<small>' . e($sub) . '</small>' : '') . '</div></div>';
    return $h;
}

/* Donut a segmenti: segments = [['value'=>n,'tone'=>'danger','label'=>'..'],...] */
function donut(array $segments, int $size = 150, int $stroke = 18, string $centerTop = '', string $centerSub = ''): string
{
    $total = array_sum(array_map(fn($s) => max(0, (float)$s['value']), $segments)) ?: 1;
    $r = ($size - $stroke) / 2;
    $c = 2 * M_PI * $r;
    $cx = $size / 2;
    $svg = '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '">';
    $svg .= '<circle class="ring-track" cx="' . $cx . '" cy="' . $cx . '" r="' . $r . '" stroke-width="' . $stroke . '" fill="none"/>';
    $acc = 0;
    $i = 0;
    foreach ($segments as $s) {
        $val = max(0, (float)$s['value']);
        if ($val <= 0) { $i++; continue; }
        $len = $c * ($val / $total);
        $offset = $c * (1 - $acc / $total);
        $svg .= '<circle class="donut-seg tone-' . e($s['tone']) . '" cx="' . $cx . '" cy="' . $cx . '" r="' . $r . '" fill="none" stroke-width="' . $stroke . '" transform="rotate(-90 ' . $cx . ' ' . $cx . ')" '
            . 'style="--dash:' . round($len, 2) . ';--gap:' . round($c - $len, 2) . ';--rot:' . round($offset, 2) . ';--i:' . $i . '"/>';
        $acc += $val;
        $i++;
    }
    $svg .= '</svg>';
    $center = '<div class="ring-center"><strong>' . e($centerTop) . '</strong>' . ($centerSub ? '<small>' . e($centerSub) . '</small>' : '') . '</div>';
    return '<div class="ring" style="width:' . $size . 'px;height:' . $size . 'px">' . $svg . $center . '</div>';
}

function legend(array $items): string
{
    $h = '<ul class="legend">';
    foreach ($items as $it) {
        $h .= '<li><i class="lg-dot tone-' . e($it['tone']) . '"></i>' . e($it['label']) . ' <b>' . e((string)$it['value']) . '</b></li>';
    }
    return $h . '</ul>';
}

/* Mini grafico a barre verticali. data = [['label'=>..,'value'=>..,'tone'=>..],...] */
function bars(array $data, ?float $target = null, string $unit = ''): string
{
    $max = max(1, max(array_map(fn($d) => (float)$d['value'], $data)));
    if ($target !== null) $max = max($max, $target);
    $h = '<div class="bars">';
    $i = 0;
    foreach ($data as $d) {
        $pct = round((float)$d['value'] / $max * 100, 1);
        $tone = $d['tone'] ?? 'primary';
        $h .= '<div class="bar-col"><div class="bar-track"><div class="bar tone-' . e($tone) . '" style="--h:' . $pct . '%;--i:' . $i . '"><span class="bar-val">' . it_num($d['value']) . '</span></div></div><span class="bar-lbl">' . e($d['label']) . '</span></div>';
        $i++;
    }
    $h .= '</div>';
    if ($target !== null) {
        $tpct = round($target / $max * 100, 1);
        $h = '<div class="bars-wrap"><div class="bars-target" style="--t:' . $tpct . '%"><span>target ' . it_num($target) . e($unit) . '</span></div>' . $h . '</div>';
    }
    return $h;
}

/* Sparkline SVG (linea che si disegna). values = numeri */
function sparkline(array $values, string $tone = 'primary', int $w = 120, int $h = 36): string
{
    if (count($values) < 2) $values = array_pad($values, 2, $values[0] ?? 0);
    $min = min($values); $max = max($values);
    $range = ($max - $min) ?: 1;
    $n = count($values);
    $pts = [];
    foreach ($values as $i => $v) {
        $x = round($i / ($n - 1) * ($w - 4) + 2, 2);
        $y = round($h - 3 - (($v - $min) / $range) * ($h - 6), 2);
        $pts[] = "$x,$y";
    }
    $d = 'M' . implode(' L', $pts);
    $area = $d . " L" . ($w - 2) . ",$h L2,$h Z";
    return '<svg class="spark tone-' . e($tone) . '" width="' . $w . '" height="' . $h . '" viewBox="0 0 ' . $w . ' ' . $h . '" preserveAspectRatio="none">'
        . '<path class="spark-area" d="' . $area . '"/>'
        . '<path class="spark-line" d="' . $d . '" fill="none" pathLength="1"/></svg>';
}

/* Stepper orizzontale. steps = [['label'=>..,'done'=>bool,'current'=>bool],...] */
function stepper(array $steps): string
{
    $h = '<ol class="stepper">';
    foreach ($steps as $s) {
        $cls = $s['done'] ?? false ? 'done' : (($s['current'] ?? false) ? 'current' : '');
        $mark = ($s['done'] ?? false) ? icon('check', 14) : e((string)($s['n'] ?? ''));
        $h .= '<li class="step ' . $cls . '"><span class="step-dot">' . $mark . '</span><span class="step-lbl">' . e($s['label']) . '</span></li>';
    }
    return $h . '</ol>';
}

function progress_bar(float $pct, string $tone = 'primary'): string
{
    $pct = max(0, min(100, $pct));
    return '<div class="pbar"><div class="pbar-fill tone-' . e($tone) . '" style="--w:' . round($pct, 1) . '%"></div></div>';
}

function avatar(string $name, string $tone = 'primary'): string
{
    $init = strtoupper(mb_substr($name, 0, 1) . (preg_match('/\s(\S)/u', $name, $m) ? $m[1] : ''));
    return '<span class="avatar avatar-sm tone-' . e($tone) . '">' . e($init) . '</span>';
}

/* ----------------------- FORM ----------------------- */
function field_input(string $name, string $label, string $value = '', string $type = 'text', string $ph = '', bool $req = false): string
{
    return '<label class="field"><span>' . e($label) . ($req ? ' *' : '') . '</span><input class="input" type="' . e($type) . '" name="' . e($name) . '" value="' . e($value) . '" placeholder="' . e($ph) . '"' . ($req ? ' required' : '') . '></label>';
}

function field_textarea(string $name, string $label, string $value = '', string $ph = ''): string
{
    return '<label class="field"><span>' . e($label) . '</span><textarea class="input" name="' . e($name) . '" placeholder="' . e($ph) . '">' . e($value) . '</textarea></label>';
}

function field_select(string $name, string $label, array $options, $selected = null, bool $req = false): string
{
    $h = '<label class="field"><span>' . e($label) . ($req ? ' *' : '') . '</span><select class="input" name="' . e($name) . '"' . ($req ? ' required' : '') . '>';
    foreach ($options as $val => $text) {
        $sel = ((string)$val === (string)$selected) ? ' selected' : '';
        $h .= '<option value="' . e((string)$val) . '"' . $sel . '>' . e($text) . '</option>';
    }
    return $h . '</select></label>';
}

function field_date(string $name, string $label, string $value = '', bool $req = false): string
{
    return '<label class="field"><span>' . e($label) . ($req ? ' *' : '') . '</span><input class="input" type="date" name="' . e($name) . '" value="' . e($value) . '"' . ($req ? ' required' : '') . '></label>';
}

function users_options(?int $selected = null, bool $blank = true): string
{
    $h = $blank ? '<option value="">—</option>' : '';
    foreach (all_rows('SELECT id, name FROM users WHERE company_id = ? AND active = 1 ORDER BY name', [current_company_id()]) as $u) {
        $sel = ((int)$u['id'] === (int)$selected) ? ' selected' : '';
        $h .= '<option value="' . (int)$u['id'] . '"' . $sel . '>' . e($u['name']) . '</option>';
    }
    return $h;
}

/* Apre un <details> usato come pannello "nuovo elemento" */
function add_panel_open(string $summary, string $action): string
{
    return '<details class="addp"><summary class="btn btn-primary">' . icon('plus', 16) . ' ' . e($summary) . '</summary>'
        . '<form class="addp-form card" method="post" enctype="multipart/form-data">'
        . csrf_field() . '<input type="hidden" name="action" value="' . e($action) . '">';
}

function add_panel_close(string $submit = 'Salva'): string
{
    return '<div class="form-actions"><button class="btn btn-primary" type="submit">' . e($submit) . '</button></div></form></details>';
}
