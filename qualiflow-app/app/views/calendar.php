<?php
$cid = current_company_id();
$today = date('Y-m-d');
$activities = all_rows("SELECT a.*, u.name owner_name FROM activities a LEFT JOIN users u ON u.id=a.owner_id WHERE a.company_id=? ORDER BY (a.status IN ('completata','annullata')), a.due_date", [$cid]);

$buckets = ['ritardo'=>[], 'settimana'=>[], 'futuro'=>[], 'fatto'=>[]];
foreach ($activities as $a) {
    if (in_array($a['status'], ['completata','annullata'], true)) { $buckets['fatto'][]=$a; continue; }
    $d = days_until($a['due_date']);
    if ($d === null) { $buckets['futuro'][]=$a; }
    elseif ($d < 0) { $buckets['ritardo'][]=$a; }
    elseif ($d <= 7) { $buckets['settimana'][]=$a; }
    else { $buckets['futuro'][]=$a; }
}

$add = add_panel_open('Nuova attività', 'save_activity');
$add .= '<div class="form-grid">';
$add .= field_input('title','Titolo','','text','Es. Verifica taratura', true);
$add .= field_select('type','Tipo', ['audit'=>'Audit','manutenzione'=>'Manutenzione','taratura'=>'Taratura','formazione'=>'Formazione','documento'=>'Documento','riunione'=>'Riunione','riesame_direzione'=>'Riesame direzione','azione_correttiva'=>'Azione correttiva','disaster_recovery'=>'Disaster recovery','fornitore'=>'Fornitore','altro'=>'Altro'], 'altro');
$add .= field_select('priority','Priorità', ['bassa'=>'Bassa','media'=>'Media','alta'=>'Alta','critica'=>'Critica'], 'media');
$add .= '<label class="field"><span>Responsabile</span><select class="input" name="owner_id">'.users_options((int)current_user()['id']).'</select></label>';
$add .= field_date('due_date','Scadenza');
$add .= field_input('frequency','Frequenza','','text','Es. Mensile');
$add .= '</div>';
$add .= field_textarea('description','Descrizione','');
$add .= add_panel_close('Aggiungi attività');

layout_start('Scadenzario', 'calendar', 'Tutte le scadenze del sistema qualità in un colpo d\'occhio', user_can_write() ? $add : '');

function activity_row(array $a): void {
    $tone = in_array($a['status'],['completata','annullata'],true) ? 'muted' : due_tone($a['due_date']);
    echo '<li class="act-row">';
    echo '<span class="act-ic tone-'.$tone.'">'.icon(match($a['type']){'audit'=>'audit','manutenzione'=>'wrench','taratura'=>'wrench','formazione'=>'training','documento'=>'document','riunione'=>'people','riesame_direzione'=>'shield','azione_correttiva'=>'check','disaster_recovery'=>'shield','fornitore'=>'partner',default=>'calendar'}, 16).'</span>';
    echo '<div class="act-body"><p class="act-title">'.e($a['title']).'</p><span class="act-meta">'.activity_type_label($a['type']);
    if ($a['owner_name']) echo ' · '.e($a['owner_name']);
    if ($a['frequency']) echo ' · '.e($a['frequency']);
    echo '</span></div>';
    echo '<div class="act-side">';
    echo badge(activity_status_label($a['status']), activity_status_tone($a['status']));
    echo '<span class="act-date tone-'.$tone.'">'.date_it($a['due_date']).'</span>';
    if (!in_array($a['status'],['completata','annullata'],true) && user_can_write()) {
        echo '<form method="post" class="inline"><input type="hidden" name="csrf_token" value="'.e(csrf_token()).'"><input type="hidden" name="action" value="complete_activity"><input type="hidden" name="id" value="'.(int)$a['id'].'"><input type="hidden" name="return" value="calendar"><button class="icon-btn ghost" title="Completa" type="submit">'.icon('check',16).'</button></form>';
    }
    echo '</div></li>';
}

$sections = [
  'ritardo'=>['In ritardo','danger'],
  'settimana'=>['Questa settimana','warning'],
  'futuro'=>['In programma','primary'],
  'fatto'=>['Completate','muted'],
];
?>
<?php foreach ($sections as $key=>[$label,$tone]): if(!$buckets[$key]) continue; ?>
<div class="card">
  <?php section_title($label, count($buckets[$key]).' attività'); ?>
  <ul class="act-list"><?php foreach ($buckets[$key] as $a) activity_row($a); ?></ul>
</div>
<?php endforeach; ?>
<?php layout_end(); ?>
