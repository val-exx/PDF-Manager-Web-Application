# Installazione rapida

## A. Demo locale con PHP (il modo più semplice)

Requisiti: **PHP 8.1+** con `pdo_sqlite`.

```bash
php scripts/init_db.php --fresh
php -S localhost:8000 -t public
```

Apri http://localhost:8000 — accedi con `admin@gestiva.local` / `password`.

Per ricaricare i dati demo da zero: `php scripts/init_db.php --fresh`.

---

## B. Con Docker

```bash
docker compose up --build
```

Il container inizializza il database demo e avvia l'app su http://localhost:8080.

---

## C. Hosting condiviso (cPanel/Plesk)

1. Carica l'intera cartella `gestiva/` nello spazio web.
2. Imposta il **document root** del dominio/sottodominio su `gestiva/public`.
   - Se non puoi cambiare il document root, sposta il contenuto di `public/` nella cartella pubblica e aggiorna i percorsi `require` in `public/index.php` (oppure usa un sottodominio puntato su `public/`).
3. Assicurati che le cartelle `storage/` e `public/uploads/` siano scrivibili (chmod 775).
4. Da terminale SSH (se disponibile): `php scripts/init_db.php --fresh`.
   - In alternativa, su MySQL importa `database/schema.mysql.sql` e `database/seed.mysql.sql` da phpMyAdmin.
5. Verifica che siano attive le estensioni PHP `pdo_sqlite` (demo) o `pdo_mysql` (produzione) e `mbstring`.

---

## D. Produzione con MySQL

1. Crea database e utente dedicati.
2. Importa lo schema e (facoltativo) i dati demo:
   ```sql
   SOURCE database/schema.mysql.sql;
   SOURCE database/seed.mysql.sql;
   ```
3. In `app/config.php`:
   ```php
   'demo_mode' => false,
   'db' => [
       'driver'   => 'mysql',
       'host'     => '127.0.0.1',
       'port'     => '3306',
       'database' => 'gestiva',
       'username' => 'gestiva_user',
       'password' => 'PASSWORD_FORTE',
       'charset'  => 'utf8mb4',
   ],
   ```
4. Configura `mail` in modalità SMTP (vedi commenti in `config.php`).
5. Pianifica i promemoria via cron:
   ```
   0 7 * * * php /percorso/gestiva/scripts/cron_reminders.php
   ```

---

## Risoluzione problemi

- **"Database non inizializzato"** → esegui `php scripts/init_db.php --fresh`.
- **Errore `pdo_sqlite` mancante** → installa/abilita `php-sqlite3`, oppure usa Docker, oppure passa a MySQL.
- **Funzione `mb_substr` mancante** → l'app include un fallback, ma è consigliato abilitare `php-mbstring`.
- **Upload non funzionanti** → verifica permessi di `public/uploads/` e `upload_max_filesize` in PHP.
