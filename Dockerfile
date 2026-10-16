# Etapa 1: compilar los recursos frontend

FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

# Etapa 2: preparar PHP y Apache

FROM php:8.3-apache

RUN apt-get update && apt-get install -y \ 
git \
unzip \
libicu-dev \ 
libzip-dev \
&& docker-php-ext-install \
pdo_mysql \
intl \
zip \
bcmath \
opcache \
&& a2enmod rewrite \ 
&& rm -rf /var/lib/apt/lists/*

# Instalar Composer

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el proyecto

COPY . .

# Instalar dependencias PHP de producción

RUN composer install \ 
--no-dev \
--optimize-autoloader \ 
--no-interaction 

# Copiar los recursos frontend compilados

COPY --from=frontend /app/public/build ./public/build

# Configurar Apache para servir desde public

RUN sed -ri \
-e 's!/var/www/html!/var/www/html/public!g' \
/etc/apache2/sites-available/*.conf \
/etc/apache2/apache2.conf \
/etc/apache2/conf-available/*.conf

# Permitir las rutas de Laravel mediante .htaccess

RUN printf '<Directory /var/www/html/public>\n \
AllowOverride All\n \
Require all granted\n </Directory>\n' \ 
> /etc/apache2/conf-available/laravel.conf \ 
&& a2enconf laravel

# Preparar el script de inicio

RUN chmod +x /var/www/html/docker-entrypoint.sh

# Permisos para Laravel

RUN chown -R www-data:www-data \
storage \
bootstrap/cache

EXPOSE 10000

CMD ["/var/www/html/docker-entrypoint.sh"]
