# QualiFlow PMI — Sistema Qualità per PMI automotive

**Il sistema qualità della tua PMI, sotto controllo.**

QualiFlow PMI è un'applicazione web per la gestione del Sistema Qualità di piccole e medie imprese, pensata per il settore automotive e conforme all'impianto di **ISO 9001:2015** e **IATF 16949:2016**.

È un'applicazione reale (PHP + database, con persistenza dei dati), non un mockup. Gira ovunque ci sia PHP: hosting condiviso, VPS, oppure Docker.

---

## Cosa gestisce

- **Cruscotto** con *Indice di prontezza audit* (gauge sintetico), KPI, scadenze e indicatori di processo.
- **Audit** interni, di certificazione (ente), fornitore e cliente: ciclo di vita completo (pianificato → in corso → rilievi → follow-up → chiuso), rilievi e punteggio.
- **Non conformità** interne ed esterne (cliente, fornitore, reclami, audit, processo) con flusso di stato e **metodo 8D** (D1–D8) e azioni correttive.
- **Checklist** ISO 9001 / IATF 16949 pronte all'uso, eseguibili con calcolo automatico del punteggio.
- **Processi**: mappa per tipologia, indicatori (KPI) con target e misurazioni, matrice rischi/opportunità P×I.
- **Documenti & Manuali** con revisioni, stati e scadenze di riesame.
- **Manutenzione** di macchine e impianti, e **tarature** degli strumenti di misura (7.1.5).
- **Formazione** con registro attestati e **matrice delle competenze** (livello attuale vs richiesto).
- **Scadenzario** unificato di tutte le attività del sistema qualità.
- **Clienti & Fornitori** con valutazione (rating) e stato di approvazione.
- **Registro attività** per la tracciabilità delle operazioni.

---

## Avvio rapido (demo, SQLite)

Richiede **PHP 8.1+** con estensioni `pdo_sqlite` (consigliata anche `mbstring`).

```bash
# 1. Inizializza il database con i dati demo
php scripts/init_db.php --fresh

# 2. Avvia il server di sviluppo
php -S localhost:8000 -t public

# 3. Apri http://localhost:8000 e accedi
```

**Accessi demo** (password per tutti: `password`):

| Ruolo | Email |
|------|------|
| Responsabile Qualità (admin) | `admin@gestiva.local` |
| Quality Engineer | `marco@gestiva.local` |
| Produzione (operatore) | `luca@gestiva.local` |
| Direzione (sola lettura) | `direzione@gestiva.local` |

> Vedi anche `INSTALLAZIONE_RAPIDA.md` per Docker e produzione.

---

## Struttura del progetto

```
qualiflow-app/
├── app/                 Logica applicativa
│   ├── config.php       Configurazione (DB, mail, upload, demo_mode)
│   ├── db.php           Connessione PDO + helper query
│   ├── auth.php         Autenticazione e sessione
│   ├── csrf.php         Protezione CSRF
│   ├── mailer.php       Invio email (in demo: log su file)
│   ├── helpers.php      Utility, etichette/tone normativi, upload, log
│   ├── ui.php           Libreria componenti + grafici SVG
│   ├── actions.php      Gestori delle azioni POST
│   └── views/           Le 19 viste dell'app
├── database/
│   ├── schema.sqlite.sql / seed.sqlite.sql      (demo)
│   └── schema.mysql.sql  / seed.mysql.sql       (produzione)
├── public/              Document root del web server
│   ├── index.php        Front controller / router
│   └── assets/          app.css, app.js, logo.svg
├── scripts/
│   ├── init_db.php      Inizializzazione database
│   └── cron_reminders.php  Promemoria scadenze (cron)
├── storage/             Database SQLite, log email
└── docs/                Note UI/UX e mappatura norme
```

---

## Sicurezza e note

- Password con hash **bcrypt**, sessioni HttpOnly + SameSite, **token CSRF** su tutte le form.
- Permessi per ruolo: *admin* e *quality_manager* scrivono; *operator* registra; *viewer* consulta.
- In demo le email sono scritte su `storage/mail.log`; gli upload sono protetti da esecuzione.
- Il database contiene **solo riferimenti sintetici** alle clausole delle norme: il testo integrale di ISO/IATF non è riprodotto (consultare le edizioni ufficiali).

## Dalla demo alla produzione

1. In `app/config.php` imposta `demo_mode => false` e configura il blocco `db` su **MySQL**.
2. Importa `database/schema.mysql.sql` e (facoltativo) `database/seed.mysql.sql`.
3. Configura `mail` in modalità SMTP.
4. Punta il document root del web server su `public/`.
5. Pianifica `scripts/cron_reminders.php` via cron per i promemoria.
