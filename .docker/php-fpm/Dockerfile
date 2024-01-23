FROM phpdockerio/php:8.2-fpm
WORKDIR "/application"
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get -o Acquire::Check-Valid-Until=false -o Acquire::Check-Date=false update \
    && apt-get -y --no-install-recommends install \
    && php-memcached \
    && php8.2-mysql \
    && php-redis \
    && php-xdebug \
    && php8.2-bcmath \
    && php8.2-gd \
    && php-imagick \
    && php8.2-imap \
    && php8.2-soap \
    && php8.2-tidy \
    && php8.2-imap \
    && php-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    &&  apt-get -o Acquire::Check-Valid-Until=false -o Acquire::Check-Date=false update \
    && apt-get -y --no-install-recommends install \
        build-essential \
        php-pear \
        php8.2-dev \
        libcurl3-openssl-dev
RUN pecl channel-update pecl.php.net
#RUN pecl install xdebug
RUN apt-get -o Acquire::Check-Valid-Until=false -o Acquire::Check-Date=false update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && apt-get clean \
    && apt-get autoremove -y
