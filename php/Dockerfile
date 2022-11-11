FROM php:8.1-fpm
# Set working directory
WORKDIR /var/www/html
# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install extensions
RUN docker-php-ext-install bcmath   mysqli pdo pdo_mysql
RUN docker-php-ext-install -j$(nproc) gd
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Add user for laravel application
RUN chmod -R 775 /var/www
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
RUN chown -R www:www /var/www
# Copy existing application directory contents
COPY . /var/www/html
# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www
# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
