<?php
/* ============================================================
 * Gestiva — gestori delle azioni POST
 * ============================================================ */

function pv(string $key, $default = ''): string
{
    $v = $_POST[$key] ?? $default;
    return is_string($v) ? trim($v) : (string)$v;
}
function pvn(string $key): ?int
{
    $v = $_POST[$key] ?? '';
    return ($v === '' || $v === null) ? null : (int)$v;
}
function pvf(string $key): ?float
{
    $v = $_POST[$key] ?? '';
    return ($v === '' || $v === null) ? null : (float)$v;
}
function pdate(string $key): ?string
{
    $v = pv($key);
    return $v !== '' ? $v : null;
}

function handle_action(string $action): void
{
    // Login è l'unica azione pubblica
    if ($action === 'login') {
        verify_csrf();
        $email = pv('email');
        $password = $_POST['password'] ?? '';
        if (attempt_login($email, $password)) {
            redirect_to('dashboard');
        }
        flash('Credenziali non valide. Riprova.', 'error');
        redirect_to('login');
    }

    if (!current_user()) redirect_to('login');
    verify_csrf();
    require_write();

    $cid = current_company_id();

    switch ($action) {

        /* ---------------- AUDIT ---------------- */
        case 'save_audit': {
            $type = in_array(pv('audit_type'), ['interno','esterno_ente','fornitore','cliente'], true) ? pv('audit_type') : 'interno';
            $code = next_code('audits', 'AUD');
            q('INSERT INTO audits (company_id, code, title, audit_type, standard, scope, partner_id, process_id, lead_auditor_id, auditee, template_id, planned_date, status)
               VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                $cid, $code, pv('title'), $type, pv('standard'), pv('scope'),
                pvn('partner_id'), pvn('process_id'), pvn('lead_auditor_id'), pv('auditee'),
                pvn('template_id'), pdate('planned_date'), 'pianificato',
            ]);
            $id = (int)db()->lastInsertId();
            log_activity('audit_creato', 'audit', $id, "Pianificato audit {$code}.");
            flash("Audit {$code} pianificato.");
            redirect_to('audit_detail', ['id' => $id]);
        }

        case 'update_audit_status': {
            $id = pvn('id');
            $status = in_array(pv('status'), ['pianificato','in_corso','rilievi','follow_up','chiuso'], true) ? pv('status') : 'pianificato';
            $score = pvn('score');
            $exec = $status === 'in_corso' ? date('Y-m-d') : null;
            q('UPDATE audits SET status = ?, score = COALESCE(?, score), executed_date = COALESCE(executed_date, ?), result_summary = COALESCE(NULLIF(?,\'\'), result_summary), updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ?',
                [$status, $score, $exec, pv('result_summary'), $id, $cid]);
            log_activity('audit_stato', 'audit', $id, "Stato audit -> {$status}.");
            flash('Stato audit aggiornato.');
            redirect_to('audit_detail', ['id' => $id]);
        }

        case 'save_finding': {
            $audit = pvn('audit_id');
            $type = in_array(pv('type'), ['nc_maggiore','nc_minore','osservazione','opportunita','punto_forza'], true) ? pv('type') : 'osservazione';
            $count = (int)(one('SELECT COUNT(*) c FROM audit_findings WHERE audit_id = ?', [$audit])['c'] ?? 0);
            $code = 'R-' . str_pad((string)($count + 1), 2, '0', STR_PAD_LEFT);
            q('INSERT INTO audit_findings (company_id, audit_id, code, type, clause_ref, description, evidence, owner_id, due_date, status)
               VALUES (?,?,?,?,?,?,?,?,?,?)', [
                $cid, $audit, $code, $type, pv('clause_ref'), pv('description'), pv('evidence'),
                pvn('owner_id'), pdate('due_date'), 'aperto',
            ]);
            // Se l'audit è in pianificato/in_corso, passa a "rilievi"
            q("UPDATE audits SET status = 'rilievi', updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ? AND status IN ('pianificato','in_corso')", [$audit, $cid]);
            log_activity('rilievo_creato', 'audit', $audit, "Aggiunto rilievo {$code}.");
            flash("Rilievo {$code} registrato.");
            redirect_to('audit_detail', ['id' => $audit]);
        }

        /* ---------------- CHECKLIST ---------------- */
        case 'start_checklist_run': {
            $tpl = pvn('template_id');
            $template = one('SELECT * FROM checklist_templates WHERE id = ?', [$tpl]);
            if (!$template) { flash('Template non trovato.', 'error'); redirect_to('checklists'); }
            $title = pv('title') ?: ('Checklist ' . $template['name']);
            q('INSERT INTO checklist_runs (company_id, template_id, audit_id, title, auditor, run_date, status) VALUES (?,?,?,?,?,?,?)', [
                $cid, $tpl, pvn('audit_id'), $title, current_user()['name'], date('Y-m-d'), 'in_corso',
            ]);
            $runId = (int)db()->lastInsertId();
            foreach (all_rows('SELECT * FROM checklist_items WHERE template_id = ? ORDER BY sort_order, id', [$tpl]) as $it) {
                q('INSERT INTO checklist_run_items (run_id, checklist_item_id, clause_code, question, answer) VALUES (?,?,?,?,?)',
                    [$runId, $it['id'], $it['clause_code'], $it['question'], 'da_valutare']);
            }
            log_activity('checklist_avviata', 'checklist_run', $runId, "Avviata {$title}.");
            redirect_to('checklist_run', ['id' => $runId]);
        }

        case 'save_run_item': {
            $itemId = pvn('item_id');
            $runId = pvn('run_id');
            $answer = in_array(pv('answer'), ['conforme','non_conforme','osservazione','na','da_valutare'], true) ? pv('answer') : 'da_valutare';
            q('UPDATE checklist_run_items SET answer = ?, notes = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND run_id = ?',
                [$answer, pv('notes'), $itemId, $runId]);
            redirect_to('checklist_run', ['id' => $runId]);
        }

        case 'complete_run': {
            $runId = pvn('id');
            $items = all_rows('SELECT answer FROM checklist_run_items WHERE run_id = ?', [$runId]);
            $conf = $nc = $na = $valued = 0;
            foreach ($items as $it) {
                if ($it['answer'] === 'conforme') $conf++;
                elseif ($it['answer'] === 'non_conforme') $nc++;
                elseif ($it['answer'] === 'na') $na++;
                if ($it['answer'] !== 'da_valutare') $valued++;
            }
            $base = max(1, $conf + $nc);
            $score = (int)round($conf / $base * 100);
            q('UPDATE checklist_runs SET status = ?, score = ?, conform_count = ?, nc_count = ?, na_count = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ?',
                ['completata', $score, $conf, $nc, $na, $runId, $cid]);
            log_activity('checklist_completata', 'checklist_run', $runId, "Checklist completata (score {$score}).");
            flash("Checklist completata. Punteggio {$score}%.");
            redirect_to('checklist_run', ['id' => $runId]);
        }

        /* ---------------- NON CONFORMITÀ ---------------- */
        case 'save_nc': {
            $source = in_array(pv('source'), ['interna','cliente','fornitore','audit','processo','reclamo'], true) ? pv('source') : 'interna';
            $sev = in_array(pv('severity'), ['bassa','media','alta','critica'], true) ? pv('severity') : 'media';
            $method = pv('method') === '8d' ? '8d' : 'standard';
            $code = next_code('non_conformities', 'NC');
            q('INSERT INTO non_conformities (company_id, code, title, description, source, partner_id, process_id, severity, status, method, detected_at, owner_id, due_date, d_step)
               VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                $cid, $code, pv('title'), pv('description'), $source, pvn('partner_id'), pvn('process_id'),
                $sev, 'aperta', $method, pdate('detected_at') ?? date('Y-m-d'), pvn('owner_id'), pdate('due_date'),
                $method === '8d' ? 1 : 0,
            ]);
            $id = (int)db()->lastInsertId();
            log_activity('nc_creata', 'non_conformity', $id, "Aperta {$code}.");
            flash("Non conformità {$code} aperta.");
            redirect_to('nc_detail', ['id' => $id]);
        }

        case 'update_nc_status': {
            $id = pvn('id');
            $status = in_array(pv('status'), ['aperta','contenimento','analisi','azioni','verifica','chiusa'], true) ? pv('status') : 'aperta';
            q('UPDATE non_conformities SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ?', [$status, $id, $cid]);
            log_activity('nc_stato', 'non_conformity', $id, "Stato NC -> {$status}.");
            flash('Stato non conformità aggiornato.');
            redirect_to('nc_detail', ['id' => $id]);
        }

        case 'save_8d': {
            $id = pvn('id');
            $step = max(0, min(8, (int)pv('d_step')));
            q('UPDATE non_conformities SET d1_team=?, d2_problem=?, d3_containment=?, d4_rootcause=?, d5_actions=?, d6_implementation=?, d7_prevention=?, d8_closure=?, d_step=?, method=\'8d\', updated_at=CURRENT_TIMESTAMP WHERE id=? AND company_id=?', [
                pv('d1_team'), pv('d2_problem'), pv('d3_containment'), pv('d4_rootcause'),
                pv('d5_actions'), pv('d6_implementation'), pv('d7_prevention'), pv('d8_closure'),
                $step, $id, $cid,
            ]);
            if ($step >= 8) {
                q("UPDATE non_conformities SET status='chiusa' WHERE id=? AND company_id=?", [$id, $cid]);
            }
            log_activity('nc_8d', 'non_conformity', $id, "Aggiornato 8D (step {$step}).");
            flash('Report 8D aggiornato.');
            redirect_to('nc_detail', ['id' => $id]);
        }

        case 'save_corrective_action': {
            $nc = pvn('non_conformity_id');
            q('INSERT INTO corrective_actions (company_id, non_conformity_id, title, description, root_cause, action_type, owner_id, due_date, status)
               VALUES (?,?,?,?,?,?,?,?,?)', [
                $cid, $nc, pv('title'), pv('description'), pv('root_cause'),
                pv('action_type') ?: 'correttiva', pvn('owner_id'), pdate('due_date'), 'aperta',
            ]);
            log_activity('azione_creata', 'corrective_action', (int)db()->lastInsertId(), 'Aggiunta azione correttiva.');
            flash('Azione correttiva aggiunta.');
            redirect_to('nc_detail', ['id' => $nc]);
        }

        case 'update_action_status': {
            $id = pvn('id'); $nc = pvn('non_conformity_id');
            $status = in_array(pv('status'), ['aperta','in_lavorazione','completata','verificata','inefficace'], true) ? pv('status') : 'aperta';
            $completed = in_array($status, ['completata','verificata'], true) ? date('Y-m-d') : null;
            q('UPDATE corrective_actions SET status=?, completed_at=COALESCE(?, completed_at), effectiveness_check=COALESCE(NULLIF(?,\'\'),effectiveness_check), updated_at=CURRENT_TIMESTAMP WHERE id=? AND company_id=?',
                [$status, $completed, pv('effectiveness_check'), $id, $cid]);
            flash('Azione aggiornata.');
            redirect_to('nc_detail', ['id' => $nc]);
        }

        /* ---------------- PROCESSI ---------------- */
        case 'save_process': {
            $type = in_array(pv('type'), ['direzione','primario','supporto'], true) ? pv('type') : 'primario';
            $code = pv('code') ?: next_code('processes', 'PRO');
            q('INSERT INTO processes (company_id, code, name, type, owner_id, purpose, inputs, outputs, status) VALUES (?,?,?,?,?,?,?,?,?)', [
                $cid, $code, pv('name'), $type, pvn('owner_id'), pv('purpose'), pv('inputs'), pv('outputs'), 'attivo',
            ]);
            log_activity('processo_creato', 'process', (int)db()->lastInsertId(), "Creato processo {$code}.");
            flash("Processo {$code} creato.");
            redirect_to('processes');
        }

        case 'save_indicator_measurement': {
            $ind = pvn('indicator_id'); $proc = pvn('process_id');
            q('INSERT INTO indicator_measurements (indicator_id, period_label, value, measured_at) VALUES (?,?,?,?)',
                [$ind, pv('period_label'), pvf('value'), pdate('measured_at') ?? date('Y-m-d')]);
            flash('Misurazione registrata.');
            redirect_to('process_detail', ['id' => $proc]);
        }

        case 'save_process_risk': {
            $type = pv('type') === 'opportunita' ? 'opportunita' : 'rischio';
            q('INSERT INTO process_risks (company_id, process_id, type, description, probability, impact, mitigation, owner_id, due_date, status) VALUES (?,?,?,?,?,?,?,?,?,?)', [
                $cid, pvn('process_id'), $type, pv('description'),
                max(1, min(5, (int)pv('probability'))), max(1, min(5, (int)pv('impact'))),
                pv('mitigation'), pvn('owner_id'), pdate('due_date'), 'aperto',
            ]);
            flash('Rischio/opportunità registrato.');
            redirect_to('process_detail', ['id' => pvn('process_id')]);
        }

        /* ---------------- DOCUMENTI ---------------- */
        case 'save_document': {
            $cat = pv('category') ?: 'procedura';
            $status = in_array(pv('status'), ['bozza','in_revisione','approvato','obsoleto','scaduto'], true) ? pv('status') : 'bozza';
            $file = save_uploaded_file('file');
            $code = pv('code') ?: next_code('documents', 'DOC');
            q('INSERT INTO documents (company_id, process_id, code, title, category, revision, status, owner_id, issue_date, review_date, expiry_date, file_path, notes)
               VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                $cid, pvn('process_id'), $code, pv('title'), $cat, pv('revision') ?: '0', $status,
                pvn('owner_id'), pdate('issue_date'), pdate('review_date'), pdate('expiry_date'), $file, pv('notes'),
            ]);
            log_activity('documento_creato', 'document', (int)db()->lastInsertId(), "Creato documento {$code}.");
            flash("Documento {$code} creato.");
            redirect_to('documents');
        }

        case 'save_document_revision': {
            $doc = pvn('document_id');
            $rev = pv('revision');
            $file = save_uploaded_file('file');
            q('INSERT INTO document_revisions (document_id, revision, change_note, changed_by, file_path) VALUES (?,?,?,?,?)',
                [$doc, $rev, pv('change_note'), current_user()['name'], $file]);
            q('UPDATE documents SET revision = ?, status = \'approvato\', file_path = COALESCE(?, file_path), updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ?',
                [$rev, $file, $doc, $cid]);
            log_activity('documento_revisione', 'document', $doc, "Nuova revisione {$rev}.");
            flash("Revisione {$rev} registrata.");
            redirect_to('documents');
        }

        /* ---------------- MANUTENZIONE / STRUMENTI ---------------- */
        case 'save_machine': {
            $code = pv('code') ?: next_code('machines', 'MAC');
            q('INSERT INTO machines (company_id, code, name, department, manufacturer, serial_number, status, owner_id) VALUES (?,?,?,?,?,?,?,?)', [
                $cid, $code, pv('name'), pv('department'), pv('manufacturer'), pv('serial_number'),
                in_array(pv('status'), ['attiva','ferma','dismessa'], true) ? pv('status') : 'attiva', pvn('owner_id'),
            ]);
            log_activity('macchina_creata', 'machine', (int)db()->lastInsertId(), "Registrata macchina {$code}.");
            flash("Macchina {$code} registrata.");
            redirect_to('machines');
        }

        case 'save_maintenance_record': {
            $machine = pvn('machine_id');
            $type = in_array(pv('type'), ['preventiva','predittiva','straordinaria','guasto'], true) ? pv('type') : 'preventiva';
            $result = in_array(pv('result'), ['ok','ko','parziale'], true) ? pv('result') : 'ok';
            $file = save_uploaded_file('file');
            q('INSERT INTO maintenance_records (company_id, machine_id, performed_at, performed_by, type, result, notes, file_path) VALUES (?,?,?,?,?,?,?,?)', [
                $cid, $machine, pdate('performed_at') ?? date('Y-m-d'), pv('performed_by') ?: current_user()['name'], $type, $result, pv('notes'), $file,
            ]);
            log_activity('manutenzione', 'machine', $machine, "Registrato intervento ({$type}).");
            flash('Intervento di manutenzione registrato.');
            redirect_to('machines');
        }

        case 'save_instrument': {
            $code = pv('code') ?: next_code('instruments', 'STR');
            $next = pdate('next_calibration');
            $status = 'idoneo';
            if ($next) {
                $d = days_until($next);
                $status = $d < 0 ? 'scaduto' : ($d <= 30 ? 'in_scadenza' : 'idoneo');
            }
            q('INSERT INTO instruments (company_id, code, name, type, location, calibration_frequency, last_calibration, next_calibration, status, owner_id) VALUES (?,?,?,?,?,?,?,?,?,?)', [
                $cid, $code, pv('name'), pv('type'), pv('location'), pv('calibration_frequency'),
                pdate('last_calibration'), $next, $status, pvn('owner_id'),
            ]);
            log_activity('strumento_creato', 'instrument', (int)db()->lastInsertId(), "Registrato strumento {$code}.");
            flash("Strumento {$code} registrato.");
            redirect_to('machines');
        }

        case 'log_calibration': {
            $id = pvn('id');
            $last = pdate('last_calibration') ?? date('Y-m-d');
            $next = pdate('next_calibration');
            $status = 'idoneo';
            if ($next) { $d = days_until($next); $status = $d < 0 ? 'scaduto' : ($d <= 30 ? 'in_scadenza' : 'idoneo'); }
            q('UPDATE instruments SET last_calibration = ?, next_calibration = COALESCE(?, next_calibration), status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ?',
                [$last, $next, $status, $id, $cid]);
            log_activity('taratura', 'instrument', $id, 'Registrata taratura.');
            flash('Taratura registrata.');
            redirect_to('machines');
        }

        /* ---------------- FORMAZIONE / COMPETENZE ---------------- */
        case 'save_person': {
            q('INSERT INTO people (company_id, name, department, role, email, active) VALUES (?,?,?,?,?,1)',
                [$cid, pv('name'), pv('department'), pv('role'), pv('email')]);
            log_activity('persona_creata', 'person', (int)db()->lastInsertId(), 'Aggiunta persona.');
            flash('Persona aggiunta.');
            redirect_to('training');
        }

        case 'save_training_record': {
            $person = pvn('person_id');
            $file = save_uploaded_file('file');
            q('INSERT INTO training_records (company_id, person_id, course_title, type, completed_at, expires_at, file_path, notes) VALUES (?,?,?,?,?,?,?,?)', [
                $cid, $person, pv('course_title'), pv('type') ?: 'awareness', pdate('completed_at'), pdate('expires_at'), $file, pv('notes'),
            ]);
            log_activity('formazione', 'person', $person, 'Registrata formazione.');
            flash('Formazione registrata.');
            redirect_to('training');
        }

        case 'set_competence': {
            $person = pvn('person_id'); $comp = pvn('competency_id');
            $req = max(0, min(4, (int)pv('required_level')));
            $cur = max(0, min(4, (int)pv('current_level')));
            $existing = one('SELECT id FROM person_competencies WHERE person_id = ? AND competency_id = ?', [$person, $comp]);
            if ($existing) {
                q('UPDATE person_competencies SET required_level = ?, current_level = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?', [$req, $cur, $existing['id']]);
            } else {
                q('INSERT INTO person_competencies (company_id, person_id, competency_id, required_level, current_level) VALUES (?,?,?,?,?)', [$cid, $person, $comp, $req, $cur]);
            }
            flash('Matrice competenze aggiornata.');
            redirect_to('training');
        }

        /* ---------------- PARTNER ---------------- */
        case 'save_partner': {
            $kind = pv('kind') === 'cliente' ? 'cliente' : 'fornitore';
            $status = in_array(pv('status'), ['approvato','in_valutazione','condizionato','sospeso'], true) ? pv('status') : 'in_valutazione';
            q('INSERT INTO partners (company_id, kind, name, vat_number, contact_name, email, phone, category, rating, status, notes) VALUES (?,?,?,?,?,?,?,?,?,?,?)', [
                $cid, $kind, pv('name'), pv('vat_number'), pv('contact_name'), pv('email'), pv('phone'),
                pv('category'), max(0, min(100, (int)(pv('rating') ?: 80))), $status, pv('notes'),
            ]);
            log_activity('partner_creato', 'partner', (int)db()->lastInsertId(), "Aggiunto {$kind}.");
            flash(ucfirst($kind) . ' aggiunto.');
            redirect_to('partners');
        }

        /* ---------------- SCADENZARIO ---------------- */
        case 'save_activity': {
            $type = pv('type');
            $valid = ['riesame_direzione','manutenzione','formazione','taratura','disaster_recovery','documento','audit','riunione','azione_correttiva','fornitore','altro'];
            if (!in_array($type, $valid, true)) $type = 'altro';
            $prio = in_array(pv('priority'), ['bassa','media','alta','critica'], true) ? pv('priority') : 'media';
            q('INSERT INTO activities (company_id, title, type, description, owner_id, due_date, frequency, status, priority) VALUES (?,?,?,?,?,?,?,?,?)', [
                $cid, pv('title'), $type, pv('description'), pvn('owner_id'), pdate('due_date'), pv('frequency'), 'aperta', $prio,
            ]);
            log_activity('attivita_creata', 'activity', (int)db()->lastInsertId(), 'Creata attività.');
            flash('Attività aggiunta allo scadenzario.');
            redirect_to('calendar');
        }

        case 'complete_activity': {
            $id = pvn('id');
            q('UPDATE activities SET status = \'completata\', completed_at = CURRENT_TIMESTAMP, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND company_id = ?', [$id, $cid]);
            log_activity('attivita_completata', 'activity', $id, 'Attività completata.');
            flash('Attività completata.');
            redirect_to($_POST['return'] ?? 'calendar');
        }

        /* ---------------- IMPOSTAZIONI ---------------- */
        case 'save_company': {
            if (!is_admin()) { flash('Solo gli amministratori possono modificare l\'azienda.', 'error'); redirect_to('settings'); }
            q('UPDATE companies SET name=?, vat_number=?, address=?, city=?, sector=?, standards=?, cert_body=?, next_audit_date=?, updated_at=CURRENT_TIMESTAMP WHERE id=?', [
                pv('name'), pv('vat_number'), pv('address'), pv('city'), pv('sector'), pv('standards'), pv('cert_body'), pdate('next_audit_date'), $cid,
            ]);
            log_activity('azienda_aggiornata', 'company', $cid, 'Aggiornati dati azienda.');
            flash('Dati azienda aggiornati.');
            redirect_to('settings');
        }

        default:
            flash('Azione non riconosciuta.', 'error');
            redirect_to('dashboard');
    }
}
