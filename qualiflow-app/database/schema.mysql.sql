-- ===========================================================
-- Gestiva - schema MySQL 8 (InnoDB, utf8mb4)
-- Generato da schema.sqlite.sql. Per uso in produzione.
-- ===========================================================
SET FOREIGN_KEY_CHECKS=0;
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
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    vat_number VARCHAR(255),
    address TEXT,
    city VARCHAR(255),
    sector VARCHAR(255),
    standards VARCHAR(255),             -- es. "ISO 9001, IATF 16949"
    cert_body TEXT,             -- ente di certificazione
    next_audit_date VARCHAR(255),       -- prossimo audit di certificazione
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'viewer' CHECK(role IN ('admin','quality_manager','operator','viewer')),
    job_title VARCHAR(255),
    active INT NOT NULL DEFAULT 1,
    last_login_at VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Clienti e fornitori (per NC esterne, 8D, audit fornitore)
CREATE TABLE partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    kind VARCHAR(255) NOT NULL DEFAULT 'fornitore' CHECK(kind IN ('cliente','fornitore')),
    name VARCHAR(255) NOT NULL,
    vat_number VARCHAR(255),
    contact_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(255),
    category VARCHAR(255),
    rating INT DEFAULT 80,           -- score 0-100
    status VARCHAR(255) NOT NULL DEFAULT 'approvato' CHECK(status IN ('approvato','in_valutazione','condizionato','sospeso')),
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- REQUISITI NORMATIVI (riferimenti sintetici, NON testo norma)
-- ============================================================
CREATE TABLE requirements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    standard VARCHAR(255) NOT NULL,
    clause_code VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    description_short TEXT,
    default_frequency VARCHAR(255),
    default_evidence TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PROCESSI (approccio per processi 4.4)
-- ============================================================
CREATE TABLE processes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL DEFAULT 'primario' CHECK(type IN ('direzione','primario','supporto')),
    owner_id INT,
    purpose TEXT,
    inputs TEXT,
    outputs TEXT,
    status VARCHAR(255) NOT NULL DEFAULT 'attivo' CHECK(status IN ('attivo','in_revisione','sospeso')),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE process_indicators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    process_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    unit VARCHAR(255),
    target DECIMAL(12,3),
    direction VARCHAR(255) NOT NULL DEFAULT 'max' CHECK(direction IN ('max','min')),
    period VARCHAR(255) DEFAULT 'mensile',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE indicator_measurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    indicator_id INT NOT NULL,
    period_label VARCHAR(255) NOT NULL,        -- es. "Gen", "Feb"...
    value DECIMAL(12,3) NOT NULL,
    measured_at VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(indicator_id) REFERENCES process_indicators(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE process_risks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    process_id INT,
    type VARCHAR(255) NOT NULL DEFAULT 'rischio' CHECK(type IN ('rischio','opportunita')),
    description TEXT NOT NULL,
    probability INT NOT NULL DEFAULT 2,   -- 1..5
    impact INT NOT NULL DEFAULT 2,        -- 1..5
    mitigation TEXT,
    owner_id INT,
    due_date VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'aperto' CHECK(status IN ('aperto','presidiato','chiuso')),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SCADENZARIO / ATTIVITA
-- ============================================================
CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    requirement_id INT,
    process_id INT,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL CHECK(type IN ('riesame_direzione','manutenzione','formazione','taratura','disaster_recovery','documento','audit','riunione','azione_correttiva','fornitore','altro')),
    description TEXT,
    owner_id INT,
    due_date VARCHAR(255),
    frequency VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'aperta' CHECK(status IN ('aperta','in_lavorazione','completata','scaduta','annullata')),
    priority VARCHAR(255) NOT NULL DEFAULT 'media' CHECK(priority IN ('bassa','media','alta','critica')),
    related_type VARCHAR(255),
    related_id INT,
    completed_at VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE evidences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    activity_id INT,
    requirement_id INT,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255),
    notes TEXT,
    uploaded_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(activity_id) REFERENCES activities(id) ON DELETE SET NULL,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(uploaded_by) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- DOCUMENTI E MANUALI
-- ============================================================
CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    requirement_id INT,
    process_id INT,
    code VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(255),             -- manuale, procedura, istruzione, modulo, registrazione, politica
    revision VARCHAR(255) DEFAULT '0',
    status VARCHAR(255) NOT NULL DEFAULT 'bozza' CHECK(status IN ('bozza','in_revisione','approvato','obsoleto','scaduto')),
    owner_id INT,
    issue_date VARCHAR(255),
    review_date VARCHAR(255),
    expiry_date VARCHAR(255),
    file_path VARCHAR(255),
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE document_revisions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    revision VARCHAR(255) NOT NULL,
    change_note TEXT,
    changed_by VARCHAR(255),
    file_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(document_id) REFERENCES documents(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- MACCHINE, MANUTENZIONE, STRUMENTI
-- ============================================================
CREATE TABLE machines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    department VARCHAR(255),
    manufacturer VARCHAR(255),
    serial_number VARCHAR(255),
    manual_file_path VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'attiva' CHECK(status IN ('attiva','ferma','dismessa')),
    owner_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE maintenance_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    machine_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL DEFAULT 'preventiva' CHECK(type IN ('preventiva','predittiva','straordinaria')),
    frequency VARCHAR(255),
    checklist VARCHAR(255),
    owner_id INT,
    next_due_date VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(machine_id) REFERENCES machines(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE maintenance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    machine_id INT NOT NULL,
    maintenance_plan_id INT,
    performed_at VARCHAR(255) NOT NULL,
    performed_by VARCHAR(255),
    type VARCHAR(255) NOT NULL DEFAULT 'preventiva' CHECK(type IN ('preventiva','predittiva','straordinaria','guasto')),
    result VARCHAR(255) NOT NULL DEFAULT 'ok' CHECK(result IN ('ok','ko','parziale')),
    notes TEXT,
    file_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(machine_id) REFERENCES machines(id) ON DELETE CASCADE,
    FOREIGN KEY(maintenance_plan_id) REFERENCES maintenance_plans(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Strumenti di misura e tarature (IATF 7.1.5)
CREATE TABLE instruments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255),
    location VARCHAR(255),
    calibration_frequency VARCHAR(255),
    last_calibration VARCHAR(255),
    next_calibration VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'idoneo' CHECK(status IN ('idoneo','in_scadenza','scaduto','fuori_uso')),
    certificate_path VARCHAR(255),
    owner_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PERSONE, FORMAZIONE, COMPETENZE
-- ============================================================
CREATE TABLE people (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    department VARCHAR(255),
    role VARCHAR(255),
    email VARCHAR(255),
    active INT NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE training_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    person_id INT NOT NULL,
    course_title VARCHAR(255) NOT NULL,
    type VARCHAR(255) DEFAULT 'awareness',
    completed_at VARCHAR(255),
    expires_at VARCHAR(255),
    file_path VARCHAR(255),
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(person_id) REFERENCES people(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Matrice competenze (7.2)
CREATE TABLE competencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    area VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE person_competencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    person_id INT NOT NULL,
    competency_id INT NOT NULL,
    required_level INT NOT NULL DEFAULT 2,  -- 0..4
    current_level INT NOT NULL DEFAULT 0,   -- 0..4
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(person_id) REFERENCES people(id) ON DELETE CASCADE,
    FOREIGN KEY(competency_id) REFERENCES competencies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- RIUNIONI / RIESAME DIREZIONE / DISASTER RECOVERY
-- ============================================================
CREATE TABLE meetings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL DEFAULT 'riunione_qualita',
    scheduled_at VARCHAR(255) NOT NULL,
    participants VARCHAR(255),
    agenda VARCHAR(255),
    minutes VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'pianificata' CHECK(status IN ('pianificata','svolta','annullata')),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE dr_tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    asset_name VARCHAR(255) NOT NULL,
    asset_type VARCHAR(255),
    backup_frequency VARCHAR(255),
    rto VARCHAR(255),
    rpo VARCHAR(255),
    test_date VARCHAR(255),
    result VARCHAR(255) NOT NULL DEFAULT 'pianificato' CHECK(result IN ('pianificato','ok','ko','parziale')),
    next_due_date VARCHAR(255),
    notes TEXT,
    file_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- AUDIT (interni / esterni ente / fornitore / cliente)
-- ============================================================
CREATE TABLE checklist_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,                -- NULL = template di sistema
    standard VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE checklist_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    template_id INT NOT NULL,
    clause_code VARCHAR(255),
    category VARCHAR(255),
    question TEXT NOT NULL,
    guidance VARCHAR(255),
    sort_order INT DEFAULT 0,
    FOREIGN KEY(template_id) REFERENCES checklist_templates(id) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE audits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    code VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    audit_type VARCHAR(255) NOT NULL DEFAULT 'interno' CHECK(audit_type IN ('interno','esterno_ente','fornitore','cliente')),
    standard VARCHAR(255),
    scope TEXT,
    partner_id INT,
    process_id INT,
    lead_auditor_id INT,
    auditee VARCHAR(255),
    template_id INT,
    planned_date VARCHAR(255),
    executed_date VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'pianificato' CHECK(status IN ('pianificato','in_corso','rilievi','follow_up','chiuso')),
    score INT,
    result_summary TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(partner_id) REFERENCES partners(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(lead_auditor_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY(template_id) REFERENCES checklist_templates(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE audit_findings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    audit_id INT NOT NULL,
    code VARCHAR(255),
    type VARCHAR(255) NOT NULL DEFAULT 'osservazione' CHECK(type IN ('nc_maggiore','nc_minore','osservazione','opportunita','punto_forza')),
    requirement_id INT,
    clause_ref VARCHAR(255),
    description TEXT NOT NULL,
    evidence TEXT,
    owner_id INT,
    due_date VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'aperto' CHECK(status IN ('aperto','in_gestione','chiuso')),
    non_conformity_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(audit_id) REFERENCES audits(id) ON DELETE CASCADE,
    FOREIGN KEY(requirement_id) REFERENCES requirements(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE checklist_runs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    template_id INT NOT NULL,
    audit_id INT,
    title VARCHAR(255) NOT NULL,
    auditor VARCHAR(255),
    run_date VARCHAR(255),
    status VARCHAR(255) NOT NULL DEFAULT 'in_corso' CHECK(status IN ('in_corso','completata')),
    score INT,
    conform_count INT DEFAULT 0,
    nc_count INT DEFAULT 0,
    na_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(template_id) REFERENCES checklist_templates(id) ON DELETE CASCADE,
    FOREIGN KEY(audit_id) REFERENCES audits(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE checklist_run_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    run_id INT NOT NULL,
    checklist_item_id INT,
    clause_code VARCHAR(255),
    question TEXT NOT NULL,
    answer VARCHAR(255) DEFAULT 'da_valutare' CHECK(answer IN ('conforme','non_conforme','osservazione','na','da_valutare')),
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(run_id) REFERENCES checklist_runs(id) ON DELETE CASCADE,
    FOREIGN KEY(checklist_item_id) REFERENCES checklist_items(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- NON CONFORMITA + 8D + AZIONI CORRETTIVE
-- ============================================================
CREATE TABLE non_conformities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    code VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    source VARCHAR(255) NOT NULL DEFAULT 'interna' CHECK(source IN ('interna','cliente','fornitore','audit','processo','reclamo')),
    partner_id INT,
    process_id INT,
    audit_finding_id INT,
    severity VARCHAR(255) NOT NULL DEFAULT 'media' CHECK(severity IN ('bassa','media','alta','critica')),
    status VARCHAR(255) NOT NULL DEFAULT 'aperta' CHECK(status IN ('aperta','contenimento','analisi','azioni','verifica','chiusa')),
    method VARCHAR(255) NOT NULL DEFAULT 'standard' CHECK(method IN ('standard','8d')),
    detected_at VARCHAR(255),
    owner_id INT,
    due_date VARCHAR(255),
    cost_estimate DECIMAL(12,3),
    -- Campi metodo 8D
    d1_team TEXT,
    d2_problem TEXT,
    d3_containment TEXT,
    d4_rootcause TEXT,
    d5_actions TEXT,
    d6_implementation TEXT,
    d7_prevention TEXT,
    d8_closure TEXT,
    d_step INT DEFAULT 0,        -- step 8D corrente (0..8)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(partner_id) REFERENCES partners(id) ON DELETE SET NULL,
    FOREIGN KEY(process_id) REFERENCES processes(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE corrective_actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    non_conformity_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    root_cause TEXT,
    action_type VARCHAR(255) NOT NULL DEFAULT 'correttiva',
    owner_id INT,
    due_date VARCHAR(255),
    completed_at VARCHAR(255),
    effectiveness_check TEXT,
    status VARCHAR(255) NOT NULL DEFAULT 'aperta' CHECK(status IN ('aperta','in_lavorazione','completata','verificata','inefficace')),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(non_conformity_id) REFERENCES non_conformities(id) ON DELETE SET NULL,
    FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- LOG E MAIL
-- ============================================================
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    subject_type VARCHAR(255),
    subject_id INT,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE SET NULL,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE mail_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    user_id INT,
    recipient VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'queued' CHECK(status IN ('queued','sent','failed')),
    sent_at VARCHAR(255),
    error VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

SET FOREIGN_KEY_CHECKS=1;
