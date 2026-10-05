# syntax=docker/dockerfile:1
FROM php:8.4-cli

# ------------------------------------------------------------
# 1. Paket sistem + ekstensi PHP (jarang berubah -> cache awet)
#    pdo_sqlite & mbstring sudah bawaan image php resmi.
# ------------------------------------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
    && docker-php-ext-install zip bcmath pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer diambil dari image resmi
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ------------------------------------------------------------
# 2. PENTING UNTUK CACHE:
#    composer.json + composer.lock disalin dan dipasang
#    SEBELUM kode aplikasi. Layer ini hanya dibangun ulang
#    jika salah satu dari dua file tersebut berubah.
# ------------------------------------------------------------
COPY composer.json composer.lock ./

RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --no-interaction \
        --prefer-dist

# ------------------------------------------------------------
# 3. Baru salin seluruh kode aplikasi.
#    Perubahan kode hanya membatalkan cache mulai dari sini.
# ------------------------------------------------------------
COPY . .

RUN composer dump-autoload --optimize --no-dev \
    && cp .env.example .env \
    && php artisan key:generate --force \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan db:seed --class=TugasSeeder --force \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
