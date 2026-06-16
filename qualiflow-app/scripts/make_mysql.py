#!/usr/bin/env python3
# Trasforma database/schema.sqlite.sql in schema.mysql.sql (MySQL 8, InnoDB, utf8mb4)
import re, pathlib

base = pathlib.Path(__file__).resolve().parents[1] / 'database'
src = (base / 'schema.sqlite.sql').read_text(encoding='utf-8')

# Nomi colonna che devono restare TEXT (contenuti lunghi)
LONG = ('description', 'notes', 'purpose', 'inputs', 'outputs', 'mitigation',
        'body', 'scope', 'evidence', 'summary', 'change_note', 'root_cause',
        'effectiveness_check', 'default_evidence', 'description_short',
        'd1_team', 'd2_problem', 'd3_containment', 'd4_rootcause', 'd5_actions',
        'd6_implementation', 'd7_prevention', 'd8_closure', 'result_summary',
        'address', 'question')

def conv_line(line: str) -> str:
    raw = line.strip()
    # PK autoincrement
    line = re.sub(r'INTEGER PRIMARY KEY AUTOINCREMENT', 'INT AUTO_INCREMENT PRIMARY KEY', line)
    # timestamp
    line = re.sub(r'\bTEXT\s+DEFAULT\s+CURRENT_TIMESTAMP', 'DATETIME DEFAULT CURRENT_TIMESTAMP', line)
    # REAL -> DECIMAL
    line = re.sub(r'\bREAL\b', 'DECIMAL(12,3)', line)
    # restanti INTEGER -> INT
    line = re.sub(r'\bINTEGER\b', 'INT', line)
    # TEXT -> VARCHAR(255) tranne colonne lunghe
    if re.search(r'\bTEXT\b', line):
        col = raw.split()[0].strip('"`') if raw and not raw.upper().startswith(('FOREIGN', 'PRIMARY', 'UNIQUE', 'CHECK', 'CONSTRAINT')) else ''
        if any(h in col for h in LONG):
            pass  # resta TEXT
        else:
            line = re.sub(r'\bTEXT\b', 'VARCHAR(255)', line, count=1)
    return line

out = []
for stmt in src.split(';'):
    s = stmt.strip()
    if not s:
        continue
    # rimuovi righe-commento iniziali per riconoscere lo statement
    body_lines = s.split('\n')
    lead = []
    while body_lines and (body_lines[0].strip().startswith('--') or body_lines[0].strip() == ''):
        lead.append(body_lines.pop(0))
    core = '\n'.join(body_lines).strip()
    lead_str = ('\n'.join(lead) + '\n') if lead else ''

    if core.upper().startswith('PRAGMA'):
        continue
    if core.upper().startswith('CREATE TABLE'):
        lines = [conv_line(l) for l in core.split('\n')]
        core = '\n'.join(lines)
        core += '\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        core = core.replace(')\n) ENGINE', '\n) ENGINE')
        out.append(lead_str + core)
    else:
        out.append(lead_str + core)

header = ("-- ===========================================================\n"
          "-- Gestiva - schema MySQL 8 (InnoDB, utf8mb4)\n"
          "-- Generato da schema.sqlite.sql. Per uso in produzione.\n"
          "-- ===========================================================\n"
          "SET FOREIGN_KEY_CHECKS=0;\n")
footer = "\nSET FOREIGN_KEY_CHECKS=1;\n"
result = header + ';\n\n'.join(out) + ';\n' + footer
(base / 'schema.mysql.sql').write_text(result, encoding='utf-8')
print('schema.mysql.sql:', len((base / 'schema.mysql.sql').read_text()), 'bytes')

# Seed: portabile (INSERT semplici). Avvolgo con disattivazione FK.
seed = (base / 'seed.sqlite.sql').read_text(encoding='utf-8')
seed_my = "SET FOREIGN_KEY_CHECKS=0;\n" + seed.strip() + "\nSET FOREIGN_KEY_CHECKS=1;\n"
(base / 'seed.mysql.sql').write_text(seed_my, encoding='utf-8')
print('seed.mysql.sql:', len(seed_my), 'bytes')
