<?php
$cid = current_company_id();
$kind = $_GET['kind'] ?? '';
$where='company_id=?'; $params=[$cid];
if (in_array($kind,['cliente','fornitore'],true)) { $where.=' AND kind=?'; $params[]=$kind; }
$partners = all_rows("SELECT * FROM partners WHERE $where ORDER BY kind, name", $params);

$nCli = (int)(one("SELECT COUNT(*) c FROM partners WHERE company_id=? AND kind='cliente'", [$cid])['c'] ?? 0);
$nFor = (int)(one("SELECT COUNT(*) c FROM partners WHERE company_id=? AND kind='fornitore'", [$cid])['c'] ?? 0);

// NC esterne per partner
$ncByPartner = [];
foreach (all_rows("SELECT partner_id, COUNT(*) c FROM non_conformities WHERE company_id=? AND partner_id IS NOT NULL AND status!='chiusa' GROUP BY partner_id", [$cid]) as $r) $ncByPartner[$r['partner_id']]=(int)$r['c'];

$add = add_panel_open('Nuovo cliente / fornitore', 'save_partner');
$add .= '<div class="form-grid">';
$add .= field_select('kind','Tipo', ['fornitore'=>'Fornitore','cliente'=>'Cliente'], 'fornitore');
$add .= field_input('name','Ragione sociale','','text','',true);
$add .= field_input('vat_number','P. IVA');
$add .= field_input('contact_name','Referente');
$add .= field_input('email','Email','','email');
$add .= field_input('phone','Telefono');
$add .= field_input('category','Categoria','','text','Es. Materia prima');
$add .= field_select('status','Stato', ['approvato'=>'Approvato','in_valutazione'=>'In valutazione','condizionato'=>'Condizionato','sospeso'=>'Sospeso'], 'in_valutazione');
$add .= field_input('rating','Rating (0-100)','80','number');
$add .= '</div>';
$add .= field_textarea('notes','Note','');
$add .= add_panel_close('Aggiungi');

layout_start('Clienti & Fornitori', 'partners', 'Anagrafica e valutazione', user_can_write() ? $add : '');
?>
<div class="filter-bar">
  <a class="chip <?= $kind===''?'on':'' ?>" href="index.php?page=partners">Tutti <b><?= $nCli+$nFor ?></b></a>
  <a class="chip <?= $kind==='cliente'?'on':'' ?>" href="index.php?page=partners&kind=cliente">Clienti <b><?= $nCli ?></b></a>
  <a class="chip <?= $kind==='fornitore'?'on':'' ?>" href="index.php?page=partners&kind=fornitore">Fornitori <b><?= $nFor ?></b></a>
</div>

<div class="card-grid">
  <?php foreach ($partners as $p): $rt = $p['rating']>=85?'success':($p['rating']>=70?'warning':'danger'); $openNc=$ncByPartner[$p['id']]??0; ?>
    <div class="partner-card card">
      <div class="partner-top">
        <span class="partner-kind"><?= $p['kind']==='cliente'?icon('building',16):icon('partner',16) ?> <?= ucfirst($p['kind']) ?></span>
        <?= badge(ucfirst(str_replace('_',' ',$p['status'])), partner_status_tone($p['status']), 'dot') ?>
      </div>
      <h3><?= e($p['name']) ?></h3>
      <p class="muted"><?= e($p['category'] ?: '—') ?><?php if($p['contact_name']):?> · <?= e($p['contact_name']) ?><?php endif;?></p>
      <div class="partner-rating">
        <div class="rating-bar"><div class="rating-fill tone-<?= $rt ?>" style="--w:<?= (int)$p['rating'] ?>%"></div></div>
        <span class="rating-num tone-<?= $rt ?>"><?= (int)$p['rating'] ?></span>
      </div>
      <div class="partner-foot">
        <?php if($openNc):?><span class="tone-danger"><?= icon('nc',13) ?> <?= $openNc ?> NC aperte</span><?php else:?><span class="tone-success"><?= icon('check',13) ?> nessuna NC aperta</span><?php endif;?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php layout_end(); ?>
