# Set the base image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Enable Apache modules
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Clone Laravel repository
RUN git clone --branch 10.x https://github.com/laravel/laravel.git .

# Install Laravel dependencies
RUN composer install --no-interaction

# Generate application key
RUN php artisan key:generate

# Set up Apache virtual host
COPY laravel.conf /etc/apache2/sites-available/laravel.conf
RUN a2ensite laravel.conf
RUN a2dissite 000-default.conf

# Install PHPMyAdmin
RUN apt-get install -y phpmyadmin
RUN ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin

# Expose ports
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
