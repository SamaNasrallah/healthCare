# استخدم صورة PHP مع Apache
FROM php:8.2-apache

# تثبيت المتطلبات الأساسية وامتدادات PHP المطلوبة
RUN apt-get update && apt-get install -y \
    libssl-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# تثبيت Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# إعداد مسار العمل داخل الحاوية
WORKDIR /var/www/html

# نسخ الملفات إلى الحاوية
COPY . .

# تثبيت الحزم المطلوبة (Composer و npm)
RUN composer install --no-dev --optimize-autoloader
RUN npm install --production && npm run build

# إعداد Laravel (إعداد التخزين والمفاتيح)
RUN php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# إعداد الأذونات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# فتح المنفذ 80
EXPOSE 80

# بدء تشغيل Apache
CMD ["apache2-foreground"]
