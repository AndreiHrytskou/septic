FROM php:7.4-apache

ARG ver
ARG network
ARG domain
ARG domain_file
ARG email
ARG container_prefix

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        wget \
        nano \
        libapache2-mod-rpaf \
        build-essential apache2-dev \
        libzip-dev \
        make \
        libmcrypt-dev
RUN docker-php-ext-install -j$(nproc) iconv  \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) mysqli
RUN docker-php-ext-install -j$(nproc) zip

RUN pecl install mcrypt-1.0.3  \
    && docker-php-ext-enable mcrypt

RUN wget -O rpaf_v0.8.4.tar.gz https://github.com/gnif/mod_rpaf/archive/v0.8.4.tar.gz
RUN gunzip rpaf_v0.8.4.tar.gz
RUN tar xvf rpaf_v0.8.4.tar
RUN cd mod_rpaf-0.8.4
RUN make; exit 0
RUN make install; exit 0

RUN a2enmod rewrite; exit 0
RUN a2ensite $domain_file; exit 0
RUN apache2 start ; exit 0

WORKDIR /var/www/html
