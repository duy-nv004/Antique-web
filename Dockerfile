# --- Giai đoạn 1: Build React Frontend ---
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY . .
RUN npm install
# Lệnh này sẽ build React (Đảm bảo lệnh này sinh ra file tĩnh trong thư mục public của Laravel)
RUN npm run build 

# --- Giai đoạn 2: Chạy Web Server PHP Laravel ---
FROM php:8.2-apache

# Cài đặt các thư viện hệ thống và các extension PHP cần thiết
# Đã thêm libpq-dev và pdo_pgsql để hỗ trợ PostgreSQL trên Render
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql

# Cấu hình Apache trỏ thẳng vào thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . .

# Copy các file build tĩnh từ Giai đoạn 1 sang Giai đoạn 2
COPY --from=frontend-builder /app/public/build ./public/build

# Cài đặt Composer cho Laravel bằng cách copy từ image Composer chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Cấp quyền ghi cho các thư mục cache/storage của Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# ĐOẠN ĐÃ SỬA: Tự động xóa cache cấu hình cũ, nạp config mới, chạy migrate và seed UserSeeder trước khi bật Apache
CMD php artisan config:clear && php artisan config:cache && php artisan migrate --force && php artisan db:seed --class=UserSeeder --force && apache2-foreground