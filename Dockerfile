FROM php:8.2-fpm

ARG user
ARG xuid

# http to https secure connection while installing packages
RUN sed -i s/http/https/g /etc/apt/sources.list.d/debian.sources

# Install dependencies
RUN apt-get update -y && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Redis
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

RUN echo "max_file_uploads=512M" >> /usr/local/etc/php/conf.d/docker-php-ext-max_file_uploads.ini
RUN echo "post_max_size=512M" >> /usr/local/etc/php/conf.d/docker-php-ext-post_max_size.ini
RUN echo "upload_max_filesize=512M" >> /usr/local/etc/php/conf.d/docker-php-ext-upload_max_filesize.ini
RUN echo "memory_limit=1G" >> /usr/local/etc/php/conf.d/docker-php-ext-memory_limit.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

#clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#set working directory
WORKDIR /var/www

USER $user