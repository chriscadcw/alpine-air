FROM php:7.4.28-fpm

RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

RUN apt-get update \
    && apt-get install -y --no-install-recommends git curl libgpgme11-dev apt-transport-https vim nano acl \
    && apt-get install -y --no-install-recommends libxml2-dev sudo telnet ntp  zlib1g-dev libicu-dev g++ \
    && pecl install gnupg \
    && echo extension=gnupg.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/20-gnupg.ini \
    && apt-get install -y unixodbc unixodbc-dev \
    && . ~/.bashrc \
    && apt-get install -y --no-install-recommends libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev  \
    && apt-get install -y wget zip unzip file \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    # gmp
    && apt-get install -y --no-install-recommends libgmp-dev libzip-dev \
    && docker-php-ext-install gmp \
    # pdo_mysql
    && docker-php-ext-install pdo_mysql \
    # opcache
    && docker-php-ext-enable opcache \
    # zip
    && docker-php-ext-install zip \
    # intl     
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    # clean up
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/pear/

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && apt-get install -y nodejs

COPY /docker/composer-install.sh /var/composer-install.sh
COPY /docker/php/start.sh /usr/local/bin/start
COPY . /var/www

RUN /bin/bash /var/composer-install.sh

RUN php -r "ini_set('error_log', '/var/log/error.log');"

RUN chmod u+x /usr/local/bin/start

WORKDIR /var/www

EXPOSE 9000

CMD ["/usr/local/bin/start"]
