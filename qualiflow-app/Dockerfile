# QualiFlow PMI — immagine demo (PHP + SQLite)
FROM php:8.3-cli

RUN docker-php-ext-install pdo_mysql >/dev/null 2>&1 || true
# pdo_sqlite e mbstring sono già inclusi nell'immagine ufficiale php:8.3-cli

WORKDIR /app
COPY . /app

# Inizializza il database demo in fase di build
RUN php scripts/init_db.php --fresh || true

EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
