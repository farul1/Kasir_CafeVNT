FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libmcrypt-dev \
    mariadb-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    libicu-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install pdo pdo_mysql gd zip intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create www user and group
RUN groupadd -g 1000 www && \
    useradd -u 1000 -g www -s /bin/bash -m www

# Update PHP configuration
RUN echo "upload_max_filesize=40M" >> /usr/local/etc/php/conf.d/local.ini && \
    echo "post_max_size=40M" >> /usr/local/etc/php/conf.d/local.ini && \
    echo "max_execution_time=180" >> /usr/local/etc/php/conf.d/local.ini && \
    echo "memory_limit=3000M" >> /usr/local/etc/php/conf.d/local.ini

# Set working directory and copy files
WORKDIR /var/www/kasir_vnt
COPY composer.* /var/www/kasir_vnt/

# Copy all files and set correct permissions
COPY . /var/www/kasir_vnt/
COPY --chown=www:www composer.* /var/www/kasir_vnt/

# Switch to www user to run PHP-FPM
USER www

# Expose port for PHP-FPM
EXPOSE 9000

# Command to run PHP-FPM
CMD ["php-fpm"]
