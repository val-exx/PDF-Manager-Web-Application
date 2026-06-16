<?php
$cid = current_company_id();
$people = all_rows("SELECT * FROM people WHERE company_id=? AND active=1 ORDER BY department, name", [$cid]);
$competencies = all_rows("SELECT * FROM competencies WHERE company_id=? ORDER BY area, name", [$cid]);
$trainings = all_rows("SELECT t.*, p.name pname FROM training_records t JOIN people p ON p.id=t.person_id WHERE t.company_id=? ORDER BY COALESCE(t.expires_at, t.completed_at) DESC", [$cid]);

// matrice competenze
$pc = [];
foreach (all_rows("SELECT * FROM person_competencies WHERE company_id=?", [$cid]) as $r) $pc[$r['person_id']][$r['competency_id']] = $r;

$expiringSoon = 0; $expired = 0; $today = date('Y-m-d');
foreach ($trainings as $t) { if ($t['expires_at']) { $d=days_until($t['expires_at']); if($d!==null){ if($d<0)$expired++; elseif($d<=30)$expiringSoon++; } } }

// gap competenze
$gaps = 0;
foreach ($pc as $pid=>$cs) foreach ($cs as $c) if ((int)$c['current_level'] < (int)$c['required_level']) $gaps++;

function level_dots(int $cur, int $req): string {
    $h = '<span class="lvl">';
    for ($i=1;$i<=4;$i++) {
        $cls = $i<=$cur ? 'on' : ($i<=$req ? 'req' : '');
        $h .= '<i class="lvl-dot '.$cls.'"></i>';
    }
    return $h.'</span>';
}

$addP = add_panel_open('Nuova persona', 'save_person');
$addP .= '<div class="form-grid">'.field_input('name','Nome','','text','Nome e cognome',true).field_input('department','Reparto').field_input('role','Ruolo').field_input('email','Email','','email').'</div>';
$addP .= add_panel_close('Aggiungi persona');

layout_start('Formazione', 'training', 'Persone, formazione e matrice delle competenze', user_can_write() ? $addP : '');
?>
<div class="hero-kpis kpis-3">
  <?php
    kpi_tile('Persone', count($people), 'in organico', 'neutral', 'people');
    kpi_tile('Attestati in scadenza', $expiringSoon, 'entro 30 giorni', $expiringSoon?'warning':'success', 'training');
    kpi_tile('Gap competenze', $gaps, 'sotto il livello richiesto', $gaps?'warning':'success', 'alert');
  ?>
</div>

<section class="card">
  <?php section_title('Matrice delle competenze', 'Livello attuale vs richiesto (0–4)'); ?>
  <?php if (!$people || !$competencies): empty_state('Aggiungi persone e competenze per costruire la matrice.','people'); else: ?>
  <div class="table-wrap">
    <table class="table matrix">
      <thead><tr><th>Persona</th><?php foreach($competencies as $c):?><th class="mx-col"><span><?= e($c['name']) ?></span></th><?php endforeach;?></tr></thead>
      <tbody>
        <?php foreach ($people as $p): ?>
          <tr>
            <td><?= avatar($p['name']) ?> <strong><?= e($p['name']) ?></strong><small class="sub"><?= e($p['department']) ?></small></td>
            <?php foreach ($competencies as $c): $cell=$pc[$p['id']][$c['id']]??null; ?>
              <td class="mx-cell"><?php if($cell): echo level_dots((int)$cell['current_level'],(int)$cell['required_level']); else: ?><span class="muted">·</span><?php endif; ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="legend-inline"><i class="lvl-dot on"></i> acquisito &nbsp; <i class="lvl-dot req"></i> richiesto &nbsp; <i class="lvl-dot"></i> da sviluppare</p>
  <?php endif; ?>
  <?php if (user_can_write() && $people && $competencies): ?>
    <?= add_panel_open('Aggiorna competenza', 'set_competence') ?>
    <div class="form-grid">
      <?php $pOpts=''; foreach($people as $p) $pOpts.='<option value="'.$p['id'].'">'.e($p['name']).'</option>'; ?>
      <?php $cOpts=''; foreach($competencies as $c) $cOpts.='<option value="'.$c['id'].'">'.e($c['name']).'</option>'; ?>
      <label class="field"><span>Persona</span><select class="input" name="person_id"><?= $pOpts ?></select></label>
      <label class="field"><span>Competenza</span><select class="input" name="competency_id"><?= $cOpts ?></select></label>
      <?= field_select('required_level','Livello richiesto', [0,1,2,3,4], 2) ?>
      <?= field_select('current_level','Livello attuale', [0,1,2,3,4], 0) ?>
    </div>
    <?= add_panel_close('Salva competenza') ?>
  <?php endif; ?>
</section>

<section class="card">
  <?php section_title('Formazione registrata', count($trainings).' attestati'); ?>
  <?php if(!$trainings): empty_state('Nessuna formazione registrata.','training'); else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Persona</th><th>Corso</th><th>Tipo</th><th>Completato</th><th>Scadenza</th></tr></thead>
      <tbody>
        <?php foreach ($trainings as $t): ?>
          <tr>
            <td><?= e($t['pname']) ?></td>
            <td><strong><?= e($t['course_title']) ?></strong></td>
            <td><?= badge(ucfirst($t['type']),'neutral') ?></td>
            <td><?= date_it($t['completed_at']) ?></td>
            <td><?= $t['expires_at'] ? '<span class="tone-'.due_tone($t['expires_at'],30).'">'.date_it($t['expires_at']).'</span>' : '<span class="muted">—</span>' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
  <?php if (user_can_write()): ?>
    <?= add_panel_open('Registra formazione', 'save_training_record') ?>
    <div class="form-grid">
      <?php $pOpts=''; foreach($people as $p) $pOpts.='<option value="'.$p['id'].'">'.e($p['name']).'</option>'; ?>
      <label class="field"><span>Persona</span><select class="input" name="person_id"><?= $pOpts ?></select></label>
      <?= field_input('course_title','Corso','','text','Es. Auditor interno',true) ?>
      <?= field_input('type','Tipo','','text','Es. qualifica / awareness') ?>
      <?= field_date('completed_at','Completato il') ?>
      <?= field_date('expires_at','Scadenza') ?>
    </div>
    <?= add_panel_close('Registra') ?>
  <?php endif; ?>
</section>
<?php layout_end(); ?>
