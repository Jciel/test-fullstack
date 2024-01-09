FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#COPY Docker/.htaccess  /etc/apache2/sites-available/000-default.conf

RUN a2enmod headers && a2enmod rewrite

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
		zlib1g-dev \
        libonig-dev \
		libzip-dev \
		unzip \
		libpng-dev \
		libpq-dev \
		libxml2-dev \
		openssl \
        cron \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
	&& docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql session xml mbstring bcmath

COPY . .

RUN chmod -R 777 /var/www/html/storage/logs/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-interaction

CMD ["apache2-foreground"]
