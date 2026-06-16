PRAGMA foreign_keys = ON;

-- Ordine di drop coerente con le foreign key
DROP TABLE IF EXISTS mail_queue;
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS checklist_run_items;
DROP TABLE IF EXISTS checklist_runs;
DROP TABLE IF EXISTS checklist_items;
DROP TABLE IF EXISTS checklist_templates;
DROP TABLE IF EXISTS audit_findings;
DROP TABLE IF EXISTS audits;
DROP TABLE IF EXISTS corrective_actions;
DROP TABLE IF EXISTS non_conformities;
DROP TABLE IF EXISTS process_risks;
DROP TABLE IF EXISTS indicator_measurements;
DROP TABLE IF EXISTS process_indicators;
DROP TABLE IF EXISTS processes;
DROP TABLE IF EXISTS person_competencies;
DROP TABLE IF EXISTS competencies;
DROP TABLE IF EXISTS training_records;
DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS instruments;
DROP TABLE IF EXISTS maintenance_records;
DROP TABLE IF EXISTS maintenance_plans;
DROP TABLE IF EXISTS machines;
DROP TABLE IF EXISTS document_revisions;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS evidences;
DROP TABLE IF EXISTS activities;
DROP TABLE IF EXISTS meetings;
DROP TABLE IF EXISTS dr_tests;
DROP TABLE IF EXISTS partners;
DROP TABLE IF EXISTS requirements;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS companies;

-- ============================================================
-- ANAGRAFICHE BASE
-- ============================================================
CREATE TABLE companies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    vat_number TEXT,
    address TEXT,
    city TEXT,
    sector TEXT,
    standards TEXT,             -- es. "ISO 9001, IATF 16949"
    cert_body TEXT,             -- ente di certificazione
    next_audit_date TEXT,       -- prossimo audit di certificazione
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'viewer' CHECK(role IN ('admin','quality_manager','operator','viewer')),
    job_title TEXT,
    active INTEGER NOT NULL DEFAULT 1,
    last_login_at TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE SET NULL
);

-- Clienti e fornitori (per NC esterne, 8D, audit fornitore)
CREATE TABLE partners (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    kind TEXT NOT NULL DEFAULT 'fornitore' CHECK(kind IN ('cliente','fornitore')),
    name TEXT NOT NULL,
    vat_number TEXT,
    contact_name TEXT,
    email TEXT,
    phone TEXT,
    category TEXT,
    rating INTEGER DEFAULT 80,           -- score 0-100
    status TEXT NOT NULL DEFAULT 'approvato' CHECK(status IN ('approvato','in_valutazione','condizionato','sospeso')),
    notes TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- ============================================================
-- REQUISITI NORMATIVI (riferimenti sintetici, NON testo norma)
-- ============================================================
CREATE TABLE requirements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    standard TEXT NOT NULL,
    clause_code TEXT NOT NULL,
    title TEXT NOT NULL,
    category TEXT NOT NULL,
    description_short TEXT,
    default_frequency TEXT,
    default_evidence TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- PROCESSI (approccio per processi 4.4)
-- ============================================================
CREATE TABLE processes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    code TEXT NOT NULL,
    name TEXT NOT NULL,
    type TEXT NOT NULL DEFAULT 'primario' CHECK(type IN ('direzione','primario','supporto')),
    owner_id INTEGER,
    purpose TEXT,
    inputs TEXT,
    outputs TEXT,
    status TEXT NOT NULL DEFAULT 'attivo' CHECK(status IN ('attivo','in_revisione','sospeso')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE process_indicators (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    process_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    unit TEXT,
    target REAL,
    direction TEXT NOT NULL DEFAULT 'max' CHECK(direction IN ('max','min')),
    period TEXT DEFAULT 'mensile',
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE CASCADE
);

CREATE TABLE indicator_measurements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    indicator_id INTEGER NOT NULL,
    period_label TEXT NOT NULL,        -- es. "Gen", "Feb"...
    value REAL NOT NULL,
    measured_at TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(indicator_id) REFERENCES process_indicators(id) ON DELETE CASCADE
);

CREATE TABLE process_risks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    process_id INTEGER,
    type TEXT NOT NULL DEFAULT 'rischio' CHECK(type IN ('rischio','opportunita')),
    description TEXT NOT NULL,
    probability INTEGER NOT NULL DEFAULT 2,   -- 1..5
    impact INTEGER NOT NULL DEFAULT 2,        -- 1..5
    mitigation TEXT,
    owner_id INTEGER,
    due_date TEXT,
    status TEXT NOT NULL DEFAULT 'aperto' CHECK(status IN ('aperto','presidiato','chiuso')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================
-- SCADENZARIO / ATTIVITA
-- ============================================================
CREATE TABLE activities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    requirement_id INTEGER,
    process_id INTEGER,
    title TEXT NOT NULL,
    type TEXT NOT NULL CHECK(type IN ('riesame_direzione','manutenzione','formazione','taratura','disaster_recovery','documento','audit','riunione','azione_correttiva','fornitore','altro')),
    description TEXT,
    owner_id INTEGER,
    due_date TEXT,
    frequency TEXT,
    status TEXT NOT NULL DEFAULT 'aperta' CHECK(status IN ('aperta','in_lavorazione','completata','scaduta','annullata')),
    priority TEXT NOT NULL DEFAULT 'media' CHECK(priority IN ('bassa','media','alta','critica')),
    related_type TEXT,
    related_id INTEGER,
    completed_at TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE evidences (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    activity_id INTEGER,
    requirement_id INTEGER,
    title TEXT NOT NULL,
    file_path TEXT,
    notes TEXT,
    uploaded_by INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(activity_id) REFERENCES activities(id) ON DELETE SET NULL,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(uploaded_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================
-- DOCUMENTI E MANUALI
-- ============================================================
CREATE TABLE documents (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    requirement_id INTEGER,
    process_id INTEGER,
    code TEXT NOT NULL,
    title TEXT NOT NULL,
    category TEXT,             -- manuale, procedura, istruzione, modulo, registrazione, politica
    revision TEXT DEFAULT '0',
    status TEXT NOT NULL DEFAULT 'bozza' CHECK(status IN ('bozza','in_revisione','approvato','obsoleto','scaduto')),
    owner_id INTEGER,
    issue_date TEXT,
    review_date TEXT,
    expiry_date TEXT,
    file_path TEXT,
    notes TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE document_revisions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    document_id INTEGER NOT NULL,
    revision TEXT NOT NULL,
    change_note TEXT,
    changed_by TEXT,
    file_path TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(document_id) REFERENCES documents(id) ON DELETE CASCADE
);

-- ============================================================
-- MACCHINE, MANUTENZIONE, STRUMENTI
-- ============================================================
CREATE TABLE machines (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    code TEXT NOT NULL,
    name TEXT NOT NULL,
    department TEXT,
    manufacturer TEXT,
    serial_number TEXT,
    manual_file_path TEXT,
    status TEXT NOT NULL DEFAULT 'attiva' CHECK(status IN ('attiva','ferma','dismessa')),
    owner_id INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE maintenance_plans (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    machine_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    type TEXT NOT NULL DEFAULT 'preventiva' CHECK(type IN ('preventiva','predittiva','straordinaria')),
    frequency TEXT,
    checklist TEXT,
    owner_id INTEGER,
    next_due_date TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(machine_id) REFERENCES machines(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE maintenance_records (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    machine_id INTEGER NOT NULL,
    maintenance_plan_id INTEGER,
    performed_at TEXT NOT NULL,
    performed_by TEXT,
    type TEXT NOT NULL DEFAULT 'preventiva' CHECK(type IN ('preventiva','predittiva','straordinaria','guasto')),
    result TEXT NOT NULL DEFAULT 'ok' CHECK(result IN ('ok','ko','parziale')),
    notes TEXT,
    file_path TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(machine_id) REFERENCES machines(id) ON DELETE CASCADE,
    FOREIGN KEY(maintenance_plan_id) REFERENCES maintenance_plans(id) ON DELETE SET NULL
);

-- Strumenti di misura e tarature (IATF 7.1.5)
CREATE TABLE instruments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    code TEXT NOT NULL,
    name TEXT NOT NULL,
    type TEXT,
    location TEXT,
    calibration_frequency TEXT,
    last_calibration TEXT,
    next_calibration TEXT,
    status TEXT NOT NULL DEFAULT 'idoneo' CHECK(status IN ('idoneo','in_scadenza','scaduto','fuori_uso')),
    certificate_path TEXT,
    owner_id INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================
-- PERSONE, FORMAZIONE, COMPETENZE
-- ============================================================
CREATE TABLE people (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    department TEXT,
    role TEXT,
    email TEXT,
    active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE training_records (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    person_id INTEGER NOT NULL,
    course_title TEXT NOT NULL,
    type TEXT DEFAULT 'awareness',
    completed_at TEXT,
    expires_at TEXT,
    file_path TEXT,
    notes TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(person_id) REFERENCES people(id) ON DELETE CASCADE
);

-- Matrice competenze (7.2)
CREATE TABLE competencies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    area TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE person_competencies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    person_id INTEGER NOT NULL,
    competency_id INTEGER NOT NULL,
    required_level INTEGER NOT NULL DEFAULT 2,  -- 0..4
    current_level INTEGER NOT NULL DEFAULT 0,   -- 0..4
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(person_id) REFERENCES people(id) ON DELETE CASCADE,
    FOREIGN KEY(competency_id) REFERENCES competencies(id) ON DELETE CASCADE
);

-- ============================================================
-- RIUNIONI / RIESAME DIREZIONE / DISASTER RECOVERY
-- ============================================================
CREATE TABLE meetings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    type TEXT NOT NULL DEFAULT 'riunione_qualita',
    scheduled_at TEXT NOT NULL,
    participants TEXT,
    agenda TEXT,
    minutes TEXT,
    status TEXT NOT NULL DEFAULT 'pianificata' CHECK(status IN ('pianificata','svolta','annullata')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE dr_tests (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    asset_name TEXT NOT NULL,
    asset_type TEXT,
    backup_frequency TEXT,
    rto TEXT,
    rpo TEXT,
    test_date TEXT,
    result TEXT NOT NULL DEFAULT 'pianificato' CHECK(result IN ('pianificato','ok','ko','parziale')),
    next_due_date TEXT,
    notes TEXT,
    file_path TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- ============================================================
-- AUDIT (interni / esterni ente / fornitore / cliente)
-- ============================================================
CREATE TABLE checklist_templates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER,                -- NULL = template di sistema
    standard TEXT NOT NULL,
    name TEXT NOT NULL,
    description TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE checklist_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    template_id INTEGER NOT NULL,
    clause_code TEXT,
    category TEXT,
    question TEXT NOT NULL,
    guidance TEXT,
    sort_order INTEGER DEFAULT 0,
    FOREIGN KEY(template_id) REFERENCES checklist_templates(id) ON DELETE CASCADE
);

CREATE TABLE audits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    code TEXT NOT NULL,
    title TEXT NOT NULL,
    audit_type TEXT NOT NULL DEFAULT 'interno' CHECK(audit_type IN ('interno','esterno_ente','fornitore','cliente')),
    standard TEXT,
    scope TEXT,
    partner_id INTEGER,
    process_id INTEGER,
    lead_auditor_id INTEGER,
    auditee TEXT,
    template_id INTEGER,
    planned_date TEXT,
    executed_date TEXT,
    status TEXT NOT NULL DEFAULT 'pianificato' CHECK(status IN ('pianificato','in_corso','rilievi','follow_up','chiuso')),
    score INTEGER,
    result_summary TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(partner_id) REFERENCES partners(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(lead_auditor_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY(template_id) REFERENCES checklist_templates(id) ON DELETE SET NULL
);

CREATE TABLE audit_findings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    audit_id INTEGER NOT NULL,
    code TEXT,
    type TEXT NOT NULL DEFAULT 'osservazione' CHECK(type IN ('nc_maggiore','nc_minore','osservazione','opportunita','punto_forza')),
    requirement_id INTEGER,
    clause_ref TEXT,
    description TEXT NOT NULL,
    evidence TEXT,
    owner_id INTEGER,
    due_date TEXT,
    status TEXT NOT NULL DEFAULT 'aperto' CHECK(status IN ('aperto','in_gestione','chiuso')),
    non_conformity_id INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(audit_id) REFERENCES audits(id) ON DELETE CASCADE,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE checklist_runs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    template_id INTEGER NOT NULL,
    audit_id INTEGER,
    title TEXT NOT NULL,
    auditor TEXT,
    run_date TEXT,
    status TEXT NOT NULL DEFAULT 'in_corso' CHECK(status IN ('in_corso','completata')),
    score INTEGER,
    conform_count INTEGER DEFAULT 0,
    nc_count INTEGER DEFAULT 0,
    na_count INTEGER DEFAULT 0,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(template_id) REFERENCES checklist_templates(id) ON DELETE CASCADE,
    FOREIGN KEY(audit_id) REFERENCES audits(id) ON DELETE SET NULL
);

CREATE TABLE checklist_run_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    run_id INTEGER NOT NULL,
    checklist_item_id INTEGER,
    clause_code TEXT,
    question TEXT NOT NULL,
    answer TEXT DEFAULT 'da_valutare' CHECK(answer IN ('conforme','non_conforme','osservazione','na','da_valutare')),
    notes TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(run_id) REFERENCES checklist_runs(id) ON DELETE CASCADE,
    FOREIGN KEY(checklist_item_id) REFERENCES checklist_items(id) ON DELETE SET NULL
);

-- ============================================================
-- NON CONFORMITA + 8D + AZIONI CORRETTIVE
-- ============================================================
CREATE TABLE non_conformities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    code TEXT NOT NULL,
    title TEXT NOT NULL,
    description TEXT,
    source TEXT NOT NULL DEFAULT 'interna' CHECK(source IN ('interna','cliente','fornitore','audit','processo','reclamo')),
    partner_id INTEGER,
    process_id INTEGER,
    audit_finding_id INTEGER,
    severity TEXT NOT NULL DEFAULT 'media' CHECK(severity IN ('bassa','media','alta','critica')),
    status TEXT NOT NULL DEFAULT 'aperta' CHECK(status IN ('aperta','contenimento','analisi','azioni','verifica','chiusa')),
    method TEXT NOT NULL DEFAULT 'standard' CHECK(method IN ('standard','8d')),
    detected_at TEXT,
    owner_id INTEGER,
    due_date TEXT,
    cost_estimate REAL,
    -- Campi metodo 8D
    d1_team TEXT,
    d2_problem TEXT,
    d3_containment TEXT,
    d4_rootcause TEXT,
    d5_actions TEXT,
    d6_implementation TEXT,
    d7_prevention TEXT,
    d8_closure TEXT,
    d_step INTEGER DEFAULT 0,        -- step 8D corrente (0..8)
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(partner_id) REFERENCES partners(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE corrective_actions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    non_conformity_id INTEGER,
    title TEXT NOT NULL,
    description TEXT,
    root_cause TEXT,
    action_type TEXT NOT NULL DEFAULT 'correttiva',
    owner_id INTEGER,
    due_date TEXT,
    completed_at TEXT,
    effectiveness_check TEXT,
    status TEXT NOT NULL DEFAULT 'aperta' CHECK(status IN ('aperta','in_lavorazione','completata','verificata','inefficace')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(non_conformity_id) REFERENCES non_conformities(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================
-- LOG E MAIL
-- ============================================================
CREATE TABLE activity_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER,
    user_id INTEGER,
    action TEXT NOT NULL,
    subject_type TEXT,
    subject_id INTEGER,
    description TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE SET NULL,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE mail_queue (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_id INTEGER NOT NULL,
    user_id INTEGER,
    recipient TEXT NOT NULL,
    subject TEXT NOT NULL,
    body TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'queued' CHECK(status IN ('queued','sent','failed')),
    sent_at TEXT,
    error TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================
-- INDICI
-- ============================================================
CREATE INDEX idx_activities_company_due ON activities(company_id, due_date);
CREATE INDEX idx_documents_company_expiry ON documents(company_id, expiry_date);
CREATE INDEX idx_nc_company_status ON non_conformities(company_id, status);
CREATE INDEX idx_actions_company_due ON corrective_actions(company_id, due_date);
CREATE INDEX idx_audits_company_status ON audits(company_id, status);
CREATE INDEX idx_findings_audit ON audit_findings(audit_id);
CREATE INDEX idx_instruments_next ON instruments(company_id, next_calibration);
CREATE INDEX idx_measure_indicator ON indicator_measurements(indicator_id);
