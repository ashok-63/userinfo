# Use the official Ubuntu base image
FROM ubuntu:22.04

# Set working directory
WORKDIR /var/www/html

# Install PHP and Apache
RUN apt-get update -y && apt-get install -y \
    apache2 \
    php8.1 \
    php8.1-cli \
    php8.1-pdo \
    php8.1-mysql \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-intl \
    php8.1-gd \
    php8.1-curl \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    curl \
    git \
    sudo

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php8.1 -- --install-dir=/usr/local/bin --filename=composer

# Copy the application code
COPY UserInfo2 . 

# Set permissions (if required for Apache to access files)
RUN chown -R www-data:www-data /var/www/html

# Install PHP extensions for GD (Graphics, used in Laravel applications for image handling)
RUN apt-get install -y libjpeg62-turbo-dev libfreetype6-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 --with-jpeg-dir=/usr/include \
    && docker-php-ext-install gd

# Expose Apache port
EXPOSE 80

# Run Apache in the foreground
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
