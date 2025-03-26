# Use a imagem base do PHP com FPM
FROM php:8.2-fpm

# Instale as dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale as extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www/auto_gestor

# Copie todos os arquivos primeiro
COPY . .

# Corrigir erro de permissões do Git
RUN git config --global --add safe.directory /var/www/auto_gestor

# Instale as dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Configure as permissões para o Laravel
RUN mkdir -p /var/www/auto_gestor/storage/logs \
    && chown -R www-data:www-data /var/www/auto_gestor/storage /var/www/auto_gestor/bootstrap/cache \
    && chmod -R 775 /var/www/auto_gestor/storage /var/www/auto_gestor/bootstrap/cache

# Exponha a porta do PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
