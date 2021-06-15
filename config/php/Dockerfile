FROM php:7.4-fpm

ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install -y --allow-downgrades \
    libz-dev \
    libzip-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libmagickwand-dev \
    libxml2-dev \
    rsyslog \
    libmariadb-dev \
    libgd-svg-perl \
    libfontconfig \
    libpq-dev \
    xvfb

RUN pecl install \
    mcrypt-1.0.4 \
    imagick
RUN curl -s http://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash && apt-get install -y nodejs

RUN docker-php-ext-enable \
    mcrypt \
    imagick

RUN docker-php-ext-install \
    pcntl \
    zip \
    pdo \
    pdo_pgsql \
    bcmath

ADD ./config.ini /usr/local/etc/php/conf.d

RUN if getent passwd www-data; then userdel -f www-data; fi
RUN if getent group www-data ; then groupdel www-data; fi
RUN groupadd -g ${GROUP_ID} www-data
RUN useradd -l -u ${USER_ID} -g www-data www-data
RUN install -d -m 0755 -o www-data -g www-data /home/www-data
RUN chown -R www-data:www-data /var/

USER www-data

CMD php-fpm;