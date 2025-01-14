# 1. استفاده از PHP نسخه 8.2 با FPM
FROM php:8.2-fpm

# 2. تنظیم دایرکتوری کاری
WORKDIR /var/www

# 3. نصب اکستنشن‌های مورد نیاز
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# 4. نصب Composer برای مدیریت پکیج‌های PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. کپی کردن تمام فایل‌های پروژه به داخل کانتینر
COPY . .

# 6. نصب وابستگی‌های PHP
RUN composer install --no-dev --optimize-autoloader

# 7. تنظیم دسترسی‌های مناسب برای storage و bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# 8. اجرای سرور PHP داخلی در پورت 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
