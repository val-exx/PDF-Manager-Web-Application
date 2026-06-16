# Deploy QualiFlow PMI su Render

Questa cartella contiene la demo PHP + SQLite interattiva di QualiFlow PMI.

## Render

1. Crea un nuovo **Web Service** su Render.
2. Collega il repository GitHub `val-exx/PDF-Manager-Web-Application`.
3. Imposta **Root Directory** su:

```text
qualiflow-app
```

4. Usa **Docker** come runtime.
5. Render usera il `Dockerfile` in questa cartella.
6. Dopo il primo deploy, apri `/index.php?page=login`.

## Dominio

Su Aruba DNS aggiungi:

```text
Tipo: CNAME
Nome: qualiflow
Valore: <hostname Render del servizio>
```

Render mostrera il valore esatto nella sezione **Custom Domains** del servizio.

## Accessi demo

Password per tutti:

```text
password
```

Utenti:

```text
admin@gestiva.local
marco@gestiva.local
luca@gestiva.local
direzione@gestiva.local
```
