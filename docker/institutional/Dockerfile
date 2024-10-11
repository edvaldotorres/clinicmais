FROM php:8.2-apache

ARG uid
ARG user

# Definindo o diretório de trabalho e as variáveis de ambiente
ENV APP_HOME /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

WORKDIR /var/www/html

# Atualizando e instalando dependências necessárias
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libsodium-dev \
    nodejs \
    npm && \
    docker-php-ext-install pdo pdo_mysql mysqli mbstring xml exif pcntl bcmath gd zip sodium && \
    docker-php-ext-enable pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiando o Composer da imagem oficial
COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

# Habilitando o mod_rewrite do Apache
RUN a2enmod rewrite && a2enmod headers

# Criando usuário para desenvolvimento e ajustando permissões
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

ENV PATH "$PATH:/home/$user/.composer/vendor/bin"

WORKDIR $APP_HOME
USER $user
