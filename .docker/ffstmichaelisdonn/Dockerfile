FROM php:8.2-fpm
RUN apt-get -o Acquire::Check-Valid-Until=false -o Acquire::Check-Date=false update \
    && apt-get install -y \
        git \
        zlib1g-dev \
        libzip-dev \
        unzip \
        libxml2-dev \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev \
        wget curl \
        libwebp-dev devscripts webp\
        imagemagick imagemagick-common libmagickwand-dev imagemagick-doc \
        htop zip \
    && apt-get clean -y \
    && docker-php-ext-install soap \
    && docker-php-ext-install pdo pdo_mysql \
    &&  apt-get -o Acquire::Check-Valid-Until=false -o Acquire::Check-Date=false update \
    && apt-get install -y \
    && apt-get clean -y \
    && docker-php-ext-install soap \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-install intl

#RUN pecl channel-update pecl.php.net
#RUN pecl install apcu \
#    && docker-php-ext-enable apcu
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && apt-get install -y locales \
    && apt-get -o Acquire::Check-Valid-Until=false -o Acquire::Check-Date=false update \
    && apt-get install libc-client-dev libkrb5-dev -y \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && apt-get clean \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
COPY . /app
WORKDIR /app

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN COMPOSER_MEMORY_LIMIT=-1 composer install
RUN php composer.phar install

EXPOSE 9000
CMD ["php-fpm"]
