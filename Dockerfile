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

# Instale Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Defina o diretório de trabalho
WORKDIR /var/www/auto_gestor

# Copie apenas os arquivos de dependências primeiro
COPY composer.json composer.lock ./

# Corrigir erro de permissões do Git
RUN git config --global --add safe.directory /var/www/auto_gestor

# Instale as dependências do Composer sem scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copie os arquivos de assets
COPY package.json package-lock.json* ./
RUN npm install

# Copie o restante do projeto e compile os assets
COPY . .
RUN npm run build

# Configure as permissões para o Laravel
RUN chown -R www-data:www-data /var/www/auto_gestor \
    && chmod -R 775 /var/www/auto_gestor/storage \
    && chmod -R 775 /var/www/auto_gestor/bootstrap/cache

# Exponha a porta do PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]