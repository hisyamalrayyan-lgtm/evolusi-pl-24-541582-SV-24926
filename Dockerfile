# syntax=docker/dockerfile:1

# ================================================================
# STAGE 1 — builder
# Image besar berisi Composer dan semua dev tools.
# Layer ini TIDAK masuk ke image akhir produksi.
# ================================================================
FROM php:8.4-cli AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
    && docker-php-ext-install zip bcmath pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Salin manifest DAHULU supaya layer Composer di-cache
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --no-interaction \
        --prefer-dist

# Baru salin kode aplikasi, lalu optimasi autoloader
COPY . .
RUN composer dump-autoload --optimize --no-dev

# ================================================================
# STAGE 2 — runtime (image final yang kecil)
# Hanya berisi PHP minimal + kode aplikasi + vendor yang sudah siap.
# ================================================================
FROM php:8.4-cli-alpine AS runtime

# Ekstensi yang dibutuhkan Laravel saat melayani request
RUN apk add --no-cache \
        libzip \
        curl \
    && docker-php-ext-install bcmath pcntl \
    && apk add --no-cache libzip-dev \
    && docker-php-ext-install zip \
    && apk del libzip-dev \
    && rm -rf /tmp/* /var/cache/apk/*

WORKDIR /app

# Salin HANYA hasil build dari stage builder (bukan semua layer builder)
COPY --from=builder /app .

# Setup environment Laravel (sqlite sudah ter-bundle di PHP Alpine)
RUN cp .env.example .env \
    && php artisan key:generate --force \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan db:seed --class=TugasSeeder --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && chmod -R 775 storage bootstrap/cache database

# Jalankan sebagai user non-root (syarat tugas)
RUN addgroup -S appgroup && adduser -S appuser -G appgroup \
    && chown -R appuser:appgroup /app

USER appuser

EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:8000/api/tugas || exit 1

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
