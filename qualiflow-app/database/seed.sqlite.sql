-- ===========================================================
-- SEED DEMO GESTIVA - PMI automotive torinese (dati di fantasia)
-- Password demo per tutti gli utenti: "password"
-- ===========================================================

INSERT INTO companies (id, name, vat_number, address, city, sector, standards, cert_body, next_audit_date) VALUES
(1, 'Meccanica Subalpina S.r.l.', 'IT09876543210', 'Via del Lingotto 42', 'Torino', 'Lavorazioni meccaniche di precisione per automotive', 'ISO 9001:2015, IATF 16949:2016', 'Ente di certificazione (demo)', '2026-11-18');

INSERT INTO users (id, company_id, name, email, password_hash, role, job_title) VALUES
(1, 1, 'Elena Ferrero', 'admin@gestiva.local', '$2y$10$wT2A5dcESHLFDy.xnIViv.d4cWhlhqpsIMdXfpE27RMsi.hp1RDCq', 'admin', 'Responsabile Qualità (RGQ)'),
(2, 1, 'Marco Rossi', 'marco@gestiva.local', '$2y$10$wT2A5dcESHLFDy.xnIViv.d4cWhlhqpsIMdXfpE27RMsi.hp1RDCq', 'quality_manager', 'Quality Engineer'),
(3, 1, 'Luca Bianchi', 'luca@gestiva.local', '$2y$10$wT2A5dcESHLFDy.xnIViv.d4cWhlhqpsIMdXfpE27RMsi.hp1RDCq', 'operator', 'Capo Reparto Produzione'),
(4, 1, 'Giorgio Conti', 'direzione@gestiva.local', '$2y$10$wT2A5dcESHLFDy.xnIViv.d4cWhlhqpsIMdXfpE27RMsi.hp1RDCq', 'viewer', 'Direzione Generale');

-- ----------------------- PARTNER -----------------------
INSERT INTO partners (id, company_id, kind, name, vat_number, contact_name, email, phone, category, rating, status, notes) VALUES
(1, 1, 'cliente', 'Torino Drive S.p.A.', 'IT01122334455', 'Ing. P. Galli', 'quality@torinodrive.example', '011 1234567', 'OEM componenti', 78, 'approvato', 'Cliente principale, fornitura componenti trasmissione.'),
(2, 1, 'cliente', 'Alpina Motors GmbH', 'DE811234567', 'M. Huber', 'spq@alpinamotors.example', '+49 89 000000', 'Tier 1 estero', 84, 'approvato', 'Richiede PPAP livello 3.'),
(3, 1, 'fornitore', 'Acciai Po S.r.l.', 'IT05566778899', 'R. Vinci', 'ordini@acciaipo.example', '011 7654321', 'Materia prima', 71, 'condizionato', 'Sotto monitoraggio per ritardi di consegna.'),
(4, 1, 'fornitore', 'Trattamenti Termici Lingotto', 'IT06677889900', 'S. Marenco', 'qualita@ttlingotto.example', '011 2223344', 'Processo speciale', 88, 'approvato', 'Tempra e cementazione. Processo speciale soggetto ad audit.'),
(5, 1, 'fornitore', 'Logistica Sabauda', 'IT07788990011', 'A. Ferro', 'info@logsabauda.example', '011 5556677', 'Trasporti', 92, 'approvato', 'Trasporti e spedizioni.');

-- ----------------------- REQUISITI -----------------------
INSERT INTO requirements (id, standard, clause_code, title, category, description_short, default_frequency, default_evidence) VALUES
(1, 'ISO 9001', '4.4', 'Sistema di gestione e processi', 'Contesto', 'Approccio per processi: sequenza, interazioni, indicatori.', 'Annuale', 'Mappa dei processi, schede processo'),
(2, 'ISO 9001', '5.1', 'Leadership e responsabilità direzione', 'Direzione', 'Coinvolgimento della direzione nel sistema qualità.', 'Annuale', 'Politica qualità, obiettivi, comunicazione'),
(3, 'ISO 9001', '6.1', 'Rischi e opportunità', 'Pianificazione', 'Registro rischi, azioni di mitigazione e riesame.', 'Annuale', 'Registro rischi aggiornato'),
(4, 'ISO 9001', '7.1.5', 'Risorse di monitoraggio e misura', 'Risorse', 'Gestione strumenti e tarature.', 'Secondo piano', 'Registro strumenti, certificati taratura'),
(5, 'ISO 9001', '7.2', 'Competenze e formazione', 'Risorse umane', 'Competenze, formazione, awareness, registri.', 'Annuale', 'Matrice competenze, attestati, registri presenza'),
(6, 'ISO 9001', '7.5', 'Informazioni documentate', 'Documenti', 'Gestione documenti, revisioni, approvazioni, archiviazione.', 'Continuo', 'Elenco documenti, procedure approvate'),
(7, 'ISO 9001', '8.4', 'Controllo fornitori e servizi esterni', 'Acquisti', 'Valutazione e monitoraggio fornitori.', 'Annuale', 'Score fornitori, certificazioni, azioni'),
(8, 'ISO 9001', '8.5', 'Produzione ed erogazione', 'Produzione', 'Controllo operativo, istruzioni e registrazioni.', 'Continuo', 'Checklist produzione, registrazioni'),
(9, 'ISO 9001', '8.7', 'Controllo degli output non conformi', 'Produzione', 'Identificazione e gestione prodotto non conforme.', 'Continuo', 'Registro NC, segregazione, deroghe'),
(10, 'ISO 9001', '9.2', 'Audit interno', 'Audit', 'Programma audit, esecuzione, rilievi, follow-up.', 'Annuale', 'Programma audit, report audit, azioni'),
(11, 'ISO 9001', '9.3', 'Riesame della direzione', 'Direzione', 'Riunione periodica: input, output, decisioni, azioni.', 'Annuale', 'Agenda, verbale, KPI, azioni'),
(12, 'ISO 9001', '10.2', 'Non conformità e azioni correttive', 'Miglioramento', 'Gestione NC, cause, azioni, verifica efficacia.', 'Continuo', 'Registro NC/CAPA'),
(13, 'IATF 16949', '8.3', 'Progettazione e sviluppo (APQP)', 'Industrializzazione', 'Pianificazione avanzata della qualità, PPAP.', 'Per progetto', 'Piano APQP, PPAP, control plan'),
(14, 'IATF 16949', '8.5.1.5', 'TPM - Manutenzione produttiva', 'Manutenzione', 'Piani manutenzione, esecuzione, storico.', 'Mensile', 'Piano manutenzione, rapporti intervento'),
(15, 'IATF 16949', '6.1.2.3', 'Piano di emergenza / continuità', 'Continuità', 'Contingency plan, test backup/ripristino.', 'Semestrale', 'Piano DR, report test restore'),
(16, 'IATF 16949', '9.2.2.3', 'Audit di processo di produzione', 'Audit', 'Audit di processo, layered process audit.', 'Annuale', 'Report audit di processo');

-- ----------------------- PROCESSI -----------------------
INSERT INTO processes (id, company_id, code, name, type, owner_id, purpose, inputs, outputs, status) VALUES
(1, 1, 'PRO-01', 'Direzione e riesame', 'direzione', 4, 'Definire politica, obiettivi e riesaminare il sistema.', 'Contesto, KPI, esiti audit', 'Obiettivi, decisioni, risorse', 'attivo'),
(2, 1, 'PRO-02', 'Commerciale e offerte', 'primario', 4, 'Gestire richieste cliente, offerte e contratti.', 'RdO cliente, capacità', 'Ordini confermati, requisiti', 'attivo'),
(3, 1, 'PRO-03', 'Industrializzazione (APQP)', 'primario', 2, 'Industrializzare nuovi prodotti secondo APQP.', 'Disegni, requisiti cliente', 'Control plan, PPAP', 'attivo'),
(4, 1, 'PRO-04', 'Produzione', 'primario', 3, 'Realizzare i componenti conformi al control plan.', 'Materia prima, ordini', 'Prodotto finito, registrazioni', 'attivo'),
(5, 1, 'PRO-05', 'Controllo qualità', 'primario', 2, 'Garantire la conformità di prodotto e processo.', 'Prodotto, control plan', 'Esiti controlli, NC', 'attivo'),
(6, 1, 'PRO-06', 'Approvvigionamenti', 'supporto', 1, 'Approvvigionare materiali e servizi conformi.', 'Fabbisogni, albo fornitori', 'Ordini, materiale, valutazioni', 'attivo'),
(7, 1, 'PRO-07', 'Manutenzione', 'supporto', 3, 'Mantenere efficienti macchine e attrezzature.', 'Piani, segnalazioni', 'Interventi, disponibilità', 'attivo'),
(8, 1, 'PRO-08', 'Risorse umane e formazione', 'supporto', 1, 'Garantire competenze adeguate.', 'Fabbisogni competenze', 'Piano formativo, registri', 'attivo');

INSERT INTO process_indicators (id, company_id, process_id, name, unit, target, direction, period) VALUES
(1, 1, 4, 'Scarti interni', 'PPM', 2000, 'min', 'mensile'),
(2, 1, 4, 'OEE', '%', 80, 'max', 'mensile'),
(3, 1, 5, 'PPM cliente', 'PPM', 50, 'min', 'mensile'),
(4, 1, 5, 'NC chiuse nei tempi', '%', 90, 'max', 'mensile'),
(5, 1, 6, 'Puntualità fornitori', '%', 95, 'max', 'mensile'),
(6, 1, 7, 'Manutenzioni preventive eseguite', '%', 95, 'max', 'mensile');

INSERT INTO indicator_measurements (indicator_id, period_label, value, measured_at) VALUES
(1, 'Gen', 3100, '2026-01-31'),(1, 'Feb', 2850, '2026-02-28'),(1, 'Mar', 2600, '2026-03-31'),(1, 'Apr', 2400, '2026-04-30'),(1, 'Mag', 2150, '2026-05-31'),(1, 'Giu', 1950, '2026-06-15'),
(2, 'Gen', 72, '2026-01-31'),(2, 'Feb', 74, '2026-02-28'),(2, 'Mar', 75, '2026-03-31'),(2, 'Apr', 78, '2026-04-30'),(2, 'Mag', 79, '2026-05-31'),(2, 'Giu', 81, '2026-06-15'),
(3, 'Gen', 95, '2026-01-31'),(3, 'Feb', 88, '2026-02-28'),(3, 'Mar', 70, '2026-03-31'),(3, 'Apr', 64, '2026-04-30'),(3, 'Mag', 58, '2026-05-31'),(3, 'Giu', 47, '2026-06-15'),
(4, 'Gen', 70, '2026-01-31'),(4, 'Feb', 75, '2026-02-28'),(4, 'Mar', 80, '2026-03-31'),(4, 'Apr', 82, '2026-04-30'),(4, 'Mag', 88, '2026-05-31'),(4, 'Giu', 91, '2026-06-15'),
(5, 'Gen', 90, '2026-01-31'),(5, 'Feb', 91, '2026-02-28'),(5, 'Mar', 89, '2026-03-31'),(5, 'Apr', 93, '2026-04-30'),(5, 'Mag', 92, '2026-05-31'),(5, 'Giu', 94, '2026-06-15'),
(6, 'Gen', 88, '2026-01-31'),(6, 'Feb', 90, '2026-02-28'),(6, 'Mar', 92, '2026-03-31'),(6, 'Apr', 95, '2026-04-30'),(6, 'Mag', 96, '2026-05-31'),(6, 'Giu', 97, '2026-06-15');

INSERT INTO process_risks (id, company_id, process_id, type, description, probability, impact, mitigation, owner_id, due_date, status) VALUES
(1, 1, 6, 'rischio', 'Ritardi di consegna materia prima dal fornitore Acciai Po.', 4, 4, 'Secondo fornitore qualificato + scorta di sicurezza.', 1, '2026-07-31', 'aperto'),
(2, 1, 4, 'rischio', 'Fermo macchina centro di lavoro CNC-02 per usura mandrino.', 3, 5, 'Manutenzione predittiva su vibrazioni + ricambi a magazzino.', 3, '2026-06-30', 'presidiato'),
(3, 1, 8, 'rischio', 'Perdita di competenze chiave per pensionamento operatore senior.', 3, 4, 'Piano di affiancamento e matrice competenze aggiornata.', 1, '2026-09-30', 'aperto'),
(4, 1, 3, 'opportunita', 'Nuova commessa Alpina Motors per componente trasmissione.', 3, 4, 'Industrializzazione APQP dedicata.', 2, '2026-10-15', 'aperto'),
(5, 1, 5, 'opportunita', 'Riduzione PPM cliente con controllo SPC esteso.', 4, 3, 'Estendere SPC alle linee critiche.', 2, '2026-08-31', 'presidiato');

-- ----------------------- DOCUMENTI -----------------------
INSERT INTO documents (id, company_id, requirement_id, process_id, code, title, category, revision, status, owner_id, issue_date, review_date, expiry_date, notes) VALUES
(1, 1, 6, 1, 'MQ-01', 'Manuale del Sistema Qualità', 'manuale', '4', 'approvato', 1, '2025-09-01', '2026-09-01', '2027-09-01', 'Manuale integrato ISO 9001 / IATF 16949.'),
(2, 1, 1, 1, 'PRO-01', 'Procedura riesame della direzione', 'procedura', '2', 'approvato', 1, '2025-10-10', '2026-10-10', NULL, NULL),
(3, 1, 12, 5, 'PRO-08', 'Procedura gestione non conformità e 8D', 'procedura', '3', 'approvato', 2, '2025-11-05', '2026-11-05', NULL, 'Include modulo 8D.'),
(4, 1, 10, 1, 'PRO-09', 'Procedura audit interni', 'procedura', '1', 'in_revisione', 2, '2026-02-01', '2026-06-20', '2026-06-20', 'Revisione in scadenza: allineare a nuovo programma audit.'),
(5, 1, 8, 4, 'IST-04', 'Istruzione controllo in accettazione', 'istruzione', '2', 'approvato', 3, '2025-12-01', '2026-12-01', NULL, NULL),
(6, 1, 4, 5, 'MOD-12', 'Modulo registro tarature', 'modulo', '1', 'approvato', 2, '2026-01-15', NULL, NULL, NULL),
(7, 1, 2, 1, 'POL-01', 'Politica per la Qualità', 'politica', '3', 'approvato', 4, '2026-01-10', '2027-01-10', NULL, 'Firmata dalla Direzione.'),
(8, 1, 8, 4, 'IST-09', 'Istruzione setup pressa', 'istruzione', '1', 'bozza', 3, '2026-06-01', NULL, NULL, 'In attesa di approvazione.'),
(9, 1, 13, 3, 'PRO-05', 'Procedura APQP e PPAP', 'procedura', '2', 'approvato', 2, '2025-08-20', '2026-08-20', NULL, NULL),
(10, 1, 6, 6, 'MOD-03', 'Modulo valutazione fornitori', 'modulo', '2', 'obsoleto', 1, '2024-05-01', NULL, '2025-12-31', 'Sostituito da MOD-03 rev.3.');

INSERT INTO document_revisions (document_id, revision, change_note, changed_by, created_at) VALUES
(1, '2', 'Aggiornamento organigramma e scopo.', 'Elena Ferrero', '2024-09-01 09:00:00'),
(1, '3', 'Integrazione requisiti IATF.', 'Elena Ferrero', '2025-03-01 09:00:00'),
(1, '4', 'Revisione processi e indicatori.', 'Elena Ferrero', '2025-09-01 09:00:00'),
(3, '2', 'Aggiunta gestione reclami cliente.', 'Marco Rossi', '2025-06-01 10:00:00'),
(3, '3', 'Introduzione metodo 8D strutturato.', 'Marco Rossi', '2025-11-05 10:00:00');

-- ----------------------- MACCHINE / MANUTENZIONE -----------------------
INSERT INTO machines (id, company_id, code, name, department, manufacturer, serial_number, status, owner_id) VALUES
(1, 1, 'CNC-01', 'Centro di lavoro 5 assi', 'Lavorazioni', 'DMG Mori (demo)', 'SN-CNC-01-2019', 'attiva', 3),
(2, 1, 'CNC-02', 'Centro di lavoro 3 assi', 'Lavorazioni', 'Haas (demo)', 'SN-CNC-02-2017', 'attiva', 3),
(3, 1, 'TOR-01', 'Tornio CNC', 'Tornitura', 'Mazak (demo)', 'SN-TOR-01-2020', 'attiva', 3),
(4, 1, 'PRS-01', 'Pressa idraulica 200t', 'Stampaggio', 'Schuler (demo)', 'SN-PRS-01-2015', 'ferma', 3),
(5, 1, 'FOR-01', 'Forno trattamento', 'Trattamenti', 'Nabertherm (demo)', 'SN-FOR-01-2018', 'attiva', 3),
(6, 1, 'MNT-01', 'Linea montaggio', 'Montaggio', 'Interno', 'SN-MNT-01-2021', 'attiva', 3);

INSERT INTO maintenance_plans (id, company_id, machine_id, title, type, frequency, checklist, owner_id, next_due_date) VALUES
(1, 1, 1, 'Manutenzione preventiva CNC-01', 'preventiva', 'Mensile', 'Lubrificazione assi; verifica fine corsa; pulizia; controllo pressione.', 3, '2026-06-20'),
(2, 1, 2, 'Manutenzione preventiva CNC-02', 'preventiva', 'Mensile', 'Lubrificazione; controllo mandrino; vibrazioni.', 3, '2026-06-10'),
(3, 1, 3, 'Manutenzione tornio TOR-01', 'preventiva', 'Bimestrale', 'Controllo torretta; lubrificazione; livelli.', 3, '2026-07-15'),
(4, 1, 5, 'Verifica forno FOR-01', 'preventiva', 'Trimestrale', 'Taratura termocoppie; tenuta; uniformità.', 3, '2026-08-01');

INSERT INTO maintenance_records (id, company_id, machine_id, maintenance_plan_id, performed_at, performed_by, type, result, notes) VALUES
(1, 1, 1, 1, '2026-05-20', 'Luca Bianchi', 'preventiva', 'ok', 'Eseguita da checklist, nessuna anomalia.'),
(2, 1, 2, 2, '2026-05-12', 'Officina esterna', 'preventiva', 'parziale', 'Rilevate vibrazioni mandrino, programmato intervento.'),
(3, 1, 4, NULL, '2026-06-08', 'Luca Bianchi', 'guasto', 'ko', 'Guasto impianto idraulico, macchina ferma in attesa ricambio.'),
(4, 1, 3, 3, '2026-04-30', 'Luca Bianchi', 'preventiva', 'ok', 'Regolare.');

INSERT INTO instruments (id, company_id, code, name, type, location, calibration_frequency, last_calibration, next_calibration, status, owner_id) VALUES
(1, 1, 'STR-01', 'Calibro digitale 0-150', 'Calibro', 'Sala metrologia', 'Annuale', '2025-09-15', '2026-09-15', 'idoneo', 2),
(2, 1, 'STR-02', 'Micrometro 0-25', 'Micrometro', 'Sala metrologia', 'Annuale', '2025-06-20', '2026-06-20', 'in_scadenza', 2),
(3, 1, 'STR-03', 'Durometro Rockwell', 'Durometro', 'Laboratorio', 'Annuale', '2025-04-01', '2026-04-01', 'scaduto', 2),
(4, 1, 'STR-04', 'CMM Macchina di misura', 'CMM', 'Sala metrologia', 'Biennale', '2025-02-10', '2027-02-10', 'idoneo', 2),
(5, 1, 'STR-05', 'Rugosimetro', 'Rugosimetro', 'Sala metrologia', 'Annuale', '2025-11-05', '2026-11-05', 'idoneo', 2),
(6, 1, 'STR-06', 'Comparatore centesimale', 'Comparatore', 'Reparto', 'Annuale', '2025-08-01', '2026-08-01', 'idoneo', 2);

-- ----------------------- PERSONE / FORMAZIONE / COMPETENZE -----------------------
INSERT INTO people (id, company_id, name, department, role, email, active) VALUES
(1, 1, 'Luca Bianchi', 'Produzione', 'Capo Reparto', 'luca@gestiva.local', 1),
(2, 1, 'Sara Greco', 'Produzione', 'Operatore CNC', 'sara@gestiva.local', 1),
(3, 1, 'Davide Russo', 'Produzione', 'Operatore CNC', 'davide@gestiva.local', 1),
(4, 1, 'Anna Moretti', 'Qualità', 'Tecnico Qualità', 'anna@gestiva.local', 1),
(5, 1, 'Paolo Gallo', 'Manutenzione', 'Manutentore', 'paolo@gestiva.local', 1),
(6, 1, 'Chiara Fontana', 'Logistica', 'Addetta Logistica', 'chiara@gestiva.local', 1),
(7, 1, 'Giovanni Ricci', 'Produzione', 'Operatore senior', 'giovanni@gestiva.local', 1),
(8, 1, 'Elena Ferrero', 'Qualità', 'RGQ', 'admin@gestiva.local', 1);

INSERT INTO training_records (id, company_id, person_id, course_title, type, completed_at, expires_at, notes) VALUES
(1, 1, 8, 'Auditor interno IATF 16949', 'qualifica', '2025-03-10', '2028-03-10', 'Qualifica auditor.'),
(2, 1, 4, 'Lettura disegno e GD&T', 'tecnica', '2025-09-15', NULL, NULL),
(3, 1, 1, 'Awareness ISO 9001 e segnalazione NC', 'awareness', '2025-07-10', '2026-07-10', 'Da rinnovare.'),
(4, 1, 2, 'Sicurezza macchine', 'sicurezza', '2024-06-01', '2026-06-01', 'Scaduta: pianificare rinnovo.'),
(5, 1, 3, 'Setup centro di lavoro', 'tecnica', '2026-02-20', NULL, NULL),
(6, 1, 5, 'Manutenzione preventiva TPM', 'tecnica', '2025-10-01', NULL, NULL),
(7, 1, 7, 'Awareness ISO 9001 e segnalazione NC', 'awareness', '2025-05-15', '2026-05-15', 'Scaduta.');

INSERT INTO competencies (id, company_id, name, area) VALUES
(1, 1, 'Programmazione CNC', 'Produzione'),
(2, 1, 'Lettura disegno tecnico', 'Produzione'),
(3, 1, 'Controllo dimensionale', 'Qualità'),
(4, 1, 'Audit interni', 'Qualità'),
(5, 1, 'Manutenzione meccanica', 'Manutenzione');

INSERT INTO person_competencies (company_id, person_id, competency_id, required_level, current_level) VALUES
(1, 1, 1, 3, 4),(1, 1, 2, 3, 3),(1, 1, 3, 2, 2),
(1, 2, 1, 3, 2),(1, 2, 2, 2, 2),(1, 2, 3, 1, 1),
(1, 3, 1, 3, 3),(1, 3, 2, 2, 1),
(1, 4, 3, 4, 3),(1, 4, 2, 3, 3),(1, 4, 4, 2, 1),
(1, 5, 5, 3, 3),
(1, 7, 1, 3, 4),(1, 7, 2, 3, 4),
(1, 8, 4, 4, 4),(1, 8, 3, 3, 3);

-- ----------------------- RIUNIONI / DR -----------------------
INSERT INTO meetings (id, company_id, title, type, scheduled_at, participants, agenda, minutes, status) VALUES
(1, 1, 'Riesame della direzione 2025', 'riesame_direzione', '2026-02-12 09:00:00', 'Direzione, RGQ, Capi reparto', 'KPI, audit, NC, risorse, obiettivi 2026', 'Approvati obiettivi 2026, stanziato budget formazione.', 'svolta'),
(2, 1, 'Riunione qualità mensile', 'riunione_qualita', '2026-06-25 14:30:00', 'RGQ, Quality, Produzione', 'Stato NC aperte, audit interni, indicatori', NULL, 'pianificata');

INSERT INTO dr_tests (id, company_id, asset_name, asset_type, backup_frequency, rto, rpo, test_date, result, next_due_date, notes) VALUES
(1, 1, 'Gestionale produzione', 'Server', 'Giornaliera', '8h', '24h', '2026-03-15', 'ok', '2026-09-15', 'Ripristino test riuscito.'),
(2, 1, 'Archivio documenti qualità', 'NAS', 'Giornaliera', '4h', '24h', '2026-05-30', 'parziale', '2026-08-30', 'Ripristino lento, da ottimizzare.');

-- ----------------------- CHECKLIST TEMPLATE -----------------------
INSERT INTO checklist_templates (id, company_id, standard, name, description) VALUES
(1, NULL, 'ISO 9001:2015', 'Audit interno di sistema ISO 9001', 'Checklist operativa per audit interno di sistema sui requisiti 4-10.'),
(2, NULL, 'IATF 16949:2016', 'Audit di processo IATF 16949', 'Checklist per audit di processo secondo approccio per processi.'),
(3, NULL, 'IATF 16949:2016', 'Audit fornitore', 'Checklist per valutazione e audit fornitori e processi speciali.');

INSERT INTO checklist_items (template_id, clause_code, category, question, guidance, sort_order) VALUES
(1, '4.4', 'Contesto', 'I processi sono mappati con input, output, indicatori e responsabili?', 'Verificare mappa processi e schede.', 1),
(1, '5.1', 'Leadership', 'La direzione dimostra leadership e comunica la politica qualità?', 'Evidenze coinvolgimento direzione.', 2),
(1, '6.1', 'Pianificazione', 'Rischi e opportunità sono identificati e gestiti con azioni?', 'Registro rischi aggiornato.', 3),
(1, '7.1.5', 'Risorse', 'Gli strumenti di misura sono identificati e tarati nei tempi?', 'Registro tarature.', 4),
(1, '7.2', 'Competenze', 'Le competenze sono definite e la formazione registrata?', 'Matrice competenze, attestati.', 5),
(1, '7.5', 'Documenti', 'I documenti sono controllati per revisione e approvazione?', 'Elenco documenti, revisioni.', 6),
(1, '8.4', 'Acquisti', 'I fornitori sono valutati e monitorati?', 'Score fornitori, azioni.', 7),
(1, '8.5', 'Produzione', 'Le lavorazioni seguono istruzioni e control plan?', 'Istruzioni, registrazioni.', 8),
(1, '8.7', 'Output NC', 'Il prodotto non conforme è identificato e segregato?', 'Registro NC, area segregazione.', 9),
(1, '9.1', 'Monitoraggio', 'Gli indicatori sono monitorati e analizzati?', 'Cruscotto KPI.', 10),
(1, '9.2', 'Audit', 'Il programma audit interni è pianificato ed eseguito?', 'Programma e report.', 11),
(1, '9.3', 'Riesame', 'Il riesame della direzione copre tutti gli input richiesti?', 'Verbale riesame.', 12),
(1, '10.2', 'Miglioramento', 'Le NC sono gestite con analisi cause e verifica efficacia?', 'Registro CAPA.', 13),
(2, '4.4', 'Processo', 'Il processo ha obiettivi e indicatori coerenti col cliente?', 'Schede processo, KPI.', 1),
(2, '8.5.1', 'Produzione', 'Esiste e si applica il control plan aggiornato?', 'Control plan in postazione.', 2),
(2, '8.5.1', 'Setup', 'Le verifiche di setup e primo pezzo sono registrate?', 'Registrazioni setup.', 3),
(2, '7.1.5', 'Misura', 'Gli strumenti in linea sono tarati e idonei?', 'Etichette taratura.', 4),
(2, '8.7', 'Reazione', 'La reazione al prodotto sospetto/NC è rapida e definita?', 'Fast response, segregazione.', 5),
(2, '8.5.1.5', 'TPM', 'La manutenzione preventiva è pianificata ed eseguita?', 'Piani e rapporti.', 6),
(2, '6.1.2.3', 'Continuità', 'Esiste un piano di emergenza per il processo?', 'Contingency plan.', 7),
(2, '10.2', 'Lezioni', 'Le lezioni apprese alimentano control plan e PFMEA?', 'Aggiornamento PFMEA.', 8),
(3, '8.4', 'Qualifica', 'Il fornitore è qualificato e ha le certificazioni richieste?', 'Certificati, albo.', 1),
(3, '8.4.2', 'Processo speciale', 'I processi speciali sono validati e monitorati?', 'Validazioni, CQI.', 2),
(3, '8.4.2', 'Performance', 'Le performance (PPM, puntualità) sono nei target?', 'Score fornitore.', 3),
(3, '10.2', 'Reattività', 'Il fornitore gestisce le NC con 8D nei tempi?', 'Report 8D fornitore.', 4);

-- ----------------------- AUDIT + RILIEVI -----------------------
INSERT INTO audits (id, company_id, code, title, audit_type, standard, scope, partner_id, process_id, lead_auditor_id, auditee, template_id, planned_date, executed_date, status, score, result_summary) VALUES
(1, 1, 'AUD-2026-01', 'Audit interno processo Produzione', 'interno', 'IATF 16949:2016', 'Processo PRO-04 Produzione, reparto lavorazioni', NULL, 4, 1, 'Luca Bianchi', 2, '2026-03-10', '2026-03-10', 'chiuso', 88, 'Processo solido. 1 NC minore su tarature, 2 osservazioni. Azioni chiuse.'),
(2, 1, 'AUD-2026-02', 'Audit interno processo Qualità', 'interno', 'ISO 9001:2015', 'Processo PRO-05 Controllo qualità', NULL, 5, 1, 'Marco Rossi', 1, '2026-06-12', '2026-06-12', 'rilievi', NULL, 'Audit eseguito, rilievi in fase di gestione.'),
(3, 1, 'AUD-2026-03', 'Audit di sorveglianza ente di certificazione', 'esterno_ente', 'ISO 9001 / IATF 16949', 'Sistema di gestione integrato', NULL, NULL, 1, 'Direzione + RGQ', NULL, '2026-11-18', NULL, 'pianificato', NULL, NULL),
(4, 1, 'AUD-2026-04', 'Audit fornitore Trattamenti Termici Lingotto', 'fornitore', 'IATF 16949:2016', 'Processo speciale: trattamento termico', 4, NULL, 2, 'TT Lingotto - Resp. Qualità', 3, '2026-05-06', '2026-05-06', 'follow_up', 76, 'Processo speciale adeguato, richieste azioni su monitoraggio forni.');

INSERT INTO audit_findings (id, company_id, audit_id, code, type, requirement_id, clause_ref, description, evidence, owner_id, due_date, status, non_conformity_id) VALUES
(1, 1, 1, 'R-01', 'nc_minore', 4, '7.1.5', 'Strumento STR-03 (durometro) con taratura scaduta ancora in uso.', 'Etichetta taratura aprile 2026.', 2, '2026-04-15', 'chiuso', 1),
(2, 1, 1, 'R-02', 'osservazione', 8, '8.5', 'Istruzione setup pressa presente in bozza ma non approvata.', 'IST-09 in stato bozza.', 3, '2026-05-30', 'in_gestione', NULL),
(3, 1, 1, 'R-03', 'opportunita', 2, '9.1', 'Possibile estensione SPC alle linee critiche per ridurre PPM.', NULL, 2, NULL, 'in_gestione', NULL),
(4, 1, 2, 'R-01', 'nc_minore', 6, '7.5', 'Procedura audit interni PRO-09 con revisione in scadenza.', 'Review date 20/06/2026.', 1, '2026-06-20', 'aperto', NULL),
(5, 1, 2, 'R-02', 'osservazione', 5, '7.2', 'Due attestati awareness scaduti non ancora rinnovati.', 'Registro formazione.', 1, '2026-07-10', 'aperto', NULL),
(6, 1, 4, 'R-01', 'nc_minore', 14, '8.5.1.5', 'Registrazioni monitoraggio uniformità forno non complete.', 'Audit fornitore.', 2, '2026-06-30', 'in_gestione', 3);

-- ----------------------- CHECKLIST RUN (eseguita) -----------------------
INSERT INTO checklist_runs (id, company_id, template_id, audit_id, title, auditor, run_date, status, score, conform_count, nc_count, na_count) VALUES
(1, 1, 2, 1, 'Checklist audit Produzione AUD-2026-01', 'Elena Ferrero', '2026-03-10', 'completata', 88, 7, 1, 0),
(2, 1, 1, 2, 'Checklist audit Qualità AUD-2026-02', 'Marco Rossi', '2026-06-12', 'in_corso', NULL, 0, 0, 0);

INSERT INTO checklist_run_items (run_id, checklist_item_id, clause_code, question, answer, notes) VALUES
(1, 14, '4.4', 'Il processo ha obiettivi e indicatori coerenti col cliente?', 'conforme', 'KPI presenti e monitorati.'),
(1, 15, '8.5.1', 'Esiste e si applica il control plan aggiornato?', 'conforme', NULL),
(1, 16, '8.5.1', 'Le verifiche di setup e primo pezzo sono registrate?', 'conforme', NULL),
(1, 17, '7.1.5', 'Gli strumenti in linea sono tarati e idonei?', 'non_conforme', 'Durometro con taratura scaduta.'),
(1, 18, '8.7', 'La reazione al prodotto sospetto/NC è rapida e definita?', 'conforme', NULL),
(1, 19, '8.5.1.5', 'La manutenzione preventiva è pianificata ed eseguita?', 'conforme', NULL),
(1, 20, '6.1.2.3', 'Esiste un piano di emergenza per il processo?', 'osservazione', 'Da aggiornare scenario fornitore.'),
(1, 21, '10.2', 'Le lezioni apprese alimentano control plan e PFMEA?', 'conforme', NULL);

-- ----------------------- NON CONFORMITA + 8D -----------------------
INSERT INTO non_conformities (id, company_id, code, title, description, source, partner_id, process_id, severity, status, method, detected_at, owner_id, due_date, cost_estimate,
    d1_team, d2_problem, d3_containment, d4_rootcause, d5_actions, d6_implementation, d7_prevention, d8_closure, d_step) VALUES
(1, 1, 'NC-2026-001', 'Strumento con taratura scaduta in uso', 'Durometro STR-03 utilizzato oltre la scadenza di taratura.', 'audit', NULL, 5, 'media', 'chiusa', 'standard', '2026-03-10', 2, '2026-04-15', NULL,
    NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
(2, 1, 'NC-2026-002', 'Reclamo cliente Torino Drive - quota fuori tolleranza', 'Lotto con diametro fuori tolleranza superiore rilevato dal cliente in accettazione.', 'cliente', 1, 4, 'alta', 'azioni', '8d', '2026-05-28', 2, '2026-06-30', 4200,
    'Team 8D: RGQ (Ferrero), Quality (Rossi), Produzione (Bianchi), Manutenzione (Gallo).',
    'Diametro Ø12 fuori tolleranza (+0,03 mm su 240 pezzi del lotto L-4471) rilevato dal cliente Torino Drive.',
    'Blocco e selezione del lotto in casa cliente e a magazzino; 100% controllo sui lotti successivi; sostituzione pezzi NC.',
    '5 Perché: usura utensile non rilevata per mancata verifica intermedia; control plan privo di controllo in process sul diametro critico.',
    'Aggiungere controllo in-process ogni 50 pezzi sul Ø critico; introdurre SPC sulla quota; aggiornare control plan e PFMEA.',
    NULL, NULL, NULL, 5),
(3, 1, 'NC-2026-003', 'Materiale fornitore non conforme (durezza)', 'Barre acciaio con durezza fuori specifica da Acciai Po.', 'fornitore', 3, 6, 'media', 'analisi', 'standard', '2026-06-02', 2, '2026-06-25', 1500,
    NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
(4, 1, 'NC-2026-004', 'Scarto interno elevato su CNC-02', 'Aumento scarti su CNC-02 legato a vibrazioni mandrino.', 'processo', NULL, 4, 'media', 'contenimento', 'standard', '2026-06-09', 3, '2026-07-05', 900,
    NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
(5, 1, 'NC-2026-005', 'Reclamo cliente Alpina Motors - imballo errato', 'Imballo non conforme alle specifiche cliente con rischio danneggiamento.', 'reclamo', 2, 4, 'bassa', 'contenimento', '8d', '2026-06-11', 1, '2026-07-15', 600,
    'Team: RGQ, Logistica (Fontana), Produzione.',
    'Imballo non conforme alla specifica PACK-AM-02 su spedizione del 10/06.',
    'Rietichettatura e reimballo della spedizione in corso; verifica giacenze.',
    NULL, NULL, NULL, NULL, NULL, 3);

INSERT INTO corrective_actions (id, company_id, non_conformity_id, title, description, root_cause, action_type, owner_id, due_date, completed_at, effectiveness_check, status) VALUES
(1, 1, 1, 'Ritiro strumento e ritaratura', 'Ritiro durometro, invio a taratura, aggiornamento registro.', 'Mancato presidio scadenze tarature.', 'correttiva', 2, '2026-04-15', '2026-04-12', 'Verificata efficacia: alert scadenze attivato.', 'verificata'),
(2, 1, 2, 'Controllo in-process Ø critico + SPC', 'Introduzione controllo ogni 50 pezzi e carta SPC sul diametro.', 'Assenza controllo in process.', 'correttiva', 3, '2026-06-28', NULL, NULL, 'in_lavorazione'),
(3, 1, 2, 'Aggiornamento control plan e PFMEA', 'Aggiornare control plan e PFMEA con nuovo punto di controllo.', NULL, 'correttiva', 2, '2026-06-30', NULL, NULL, 'aperta'),
(4, 1, 3, 'Reso al fornitore e azione 8D', 'Richiesta 8D al fornitore Acciai Po e reso materiale.', NULL, 'correttiva', 2, '2026-06-25', NULL, NULL, 'in_lavorazione'),
(5, 1, 4, 'Manutenzione mandrino CNC-02', 'Intervento su mandrino e verifica vibrazioni.', 'Usura mandrino.', 'correttiva', 3, '2026-06-30', NULL, NULL, 'aperta');

-- ----------------------- SCADENZARIO / ATTIVITA -----------------------
INSERT INTO activities (id, company_id, requirement_id, process_id, title, type, description, owner_id, due_date, frequency, status, priority) VALUES
(1, 1, 10, 1, 'Audit interno processo Qualità - follow up rilievi', 'audit', 'Gestire i rilievi dell audit AUD-2026-02.', 1, '2026-06-20', 'Annuale', 'in_lavorazione', 'alta'),
(2, 1, 4, 5, 'Ritaratura durometro STR-03', 'taratura', 'Strumento scaduto da inviare a taratura.', 2, '2026-06-05', NULL, 'scaduta', 'critica'),
(3, 1, 14, 7, 'Manutenzione preventiva CNC-02', 'manutenzione', 'Intervento mandrino e checklist mensile.', 3, '2026-06-10', 'Mensile', 'scaduta', 'alta'),
(4, 1, 5, 8, 'Rinnovo awareness ISO 9001 operatori', 'formazione', 'Rinnovare attestati scaduti (2 operatori).', 1, '2026-07-10', 'Annuale', 'aperta', 'media'),
(5, 1, 11, 1, 'Riunione qualità mensile', 'riunione', 'Riunione indicatori e NC.', 1, '2026-06-25', 'Mensile', 'aperta', 'media'),
(6, 1, 7, 6, 'Valutazione annuale fornitori', 'fornitore', 'Aggiornare score e raccogliere certificazioni.', 1, '2026-09-30', 'Annuale', 'aperta', 'media'),
(7, 1, 15, 1, 'Test ripristino backup archivio qualità', 'disaster_recovery', 'Eseguire test restore semestrale.', 1, '2026-08-30', 'Semestrale', 'aperta', 'media'),
(8, 1, 6, 1, 'Approvazione revisione PRO-09 audit interni', 'documento', 'Completare revisione procedura audit.', 1, '2026-06-20', NULL, 'in_lavorazione', 'alta'),
(9, 1, 4, 5, 'Taratura micrometro STR-02', 'taratura', 'Strumento in scadenza taratura.', 2, '2026-06-20', 'Annuale', 'aperta', 'alta'),
(10, 1, 12, 4, 'Chiusura azioni 8D NC-2026-002', 'azione_correttiva', 'Implementare e verificare azioni 8D reclamo cliente.', 2, '2026-06-30', NULL, 'in_lavorazione', 'critica'),
(11, 1, 11, 1, 'Riesame della direzione 2026', 'riesame_direzione', 'Preparare input e convocare riesame.', 4, '2026-02-12', 'Annuale', 'completata', 'alta'),
(12, 1, 14, 7, 'Manutenzione preventiva CNC-01', 'manutenzione', 'Checklist mensile centro 5 assi.', 3, '2026-06-20', 'Mensile', 'aperta', 'media');

UPDATE activities SET completed_at = '2026-02-12' WHERE id = 11;

-- ----------------------- LOG ATTIVITA -----------------------
INSERT INTO activity_logs (company_id, user_id, action, subject_type, subject_id, description, created_at) VALUES
(1, 1, 'audit_eseguito', 'audit', 1, 'Chiuso audit interno AUD-2026-01 (score 88).', '2026-03-12 11:00:00'),
(1, 2, 'nc_creata', 'non_conformity', 2, 'Aperta NC-2026-002 da reclamo cliente Torino Drive.', '2026-05-28 16:20:00'),
(1, 2, 'azione_aggiornata', 'corrective_action', 1, 'Verificata efficacia azione su NC-2026-001.', '2026-04-12 09:30:00'),
(1, 1, 'documento_revisione', 'document', 4, 'Avviata revisione PRO-09 procedura audit interni.', '2026-06-01 10:15:00'),
(1, 3, 'manutenzione', 'machine', 4, 'Registrato guasto pressa PRS-01.', '2026-06-08 08:05:00');
