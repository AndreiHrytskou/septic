FROM php:7.3-apache

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
        s3fs \
        libmcrypt-dev \
#        && docker-php-ext-install -j$(nproc) iconv intl xml soap mcrypt opcache pdo pdo_mysql mysqli mbstring \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd
#RUN docker-php-ext-install -j$(nproc) iconv  \
#        && docker-php-ext-configure gd --with-freetype --with-jpeg \
#        && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) mysqli
RUN docker-php-ext-install -j$(nproc) zip

RUN pecl install mcrypt-1.0.3  \
    && docker-php-ext-enable mcrypt

RUN wget http://downloads3.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.tar.gz
RUN tar xzf ioncube_loaders_lin_x86-64.tar.gz -C /usr/local

RUN wget -O rpaf_v0.8.4.tar.gz https://github.com/gnif/mod_rpaf/archive/v0.8.4.tar.gz
RUN gunzip rpaf_v0.8.4.tar.gz
RUN tar xvf rpaf_v0.8.4.tar
RUN cd mod_rpaf-0.8.4
RUN make; exit 0
RUN make install; exit 0

ARG ver
ARG network
ARG domain
ARG domain_file
ARG email
ARG container_prefix
ARG num
ARG apache_port

RUN echo '<VirtualHost *:'$apache_port'>                                \n \
    ServerName '$domain'                                    \n \
	ServerAlias www.'$domain'                               \n \
                                                            \n \
    	ServerAdmin admin@'$domain'                         \n \
    	DocumentRoot /var/www/html                          \n \
                                                            \n \
    	ErrorLog ${APACHE_LOG_DIR}/'$domain_file'_error.log                    \n \
    	CustomLog ${APACHE_LOG_DIR}/'$domain_file'_access.log vhost_combined   \n \
                                                                                  \n \
    	ProxyPassMatch ^/.*?/APP.*?/v[0-9]+/(.*)$ "http://localhost/var/www/html"   \n \
                                                                                                                \n \
</VirtualHost>' > /etc/apache2/sites-available/$domain_file.conf

RUN echo '<IfModule mod_rpaf.c>                                 \n \
              RPAF_Enable             On                        \n \
              RPAF_ProxyIPs           '$network'.'$num' ::0           \n \
          	RPAF_SetHostName        On                          \n \
          	RPAF_SetHTTPS           On                          \n \
          	RPAF_SetPort            On                          \n \
          	RPAF_ForbidIfNotProxy   Off                         \n \
          	RPAF_Header				 X-Forwarded-For            \n \
          </IfModule>' > /etc/apache2/mods-available/rpaf.conf

RUN echo 'Listen *:'$apache_port'                                         \n \
                                                              \n \
          <IfModule ssl_module>                               \n \
                  Listen 443                                  \n \
          </IfModule>                                         \n \
                                                              \n \
          <IfModule mod_gnutls.c>                             \n \
                  Listen 443                                  \n \
          </IfModule>' > /etc/apache2/ports.conf

RUN a2enmod proxy_http; exit 0
RUN a2enmod rewrite; exit 0
RUN a2ensite $domain_file.conf; exit 0
RUN apache2 start ; exit 0

#RUN echo cv29378:986833804107b1bde0839cec413a9ace >  ~/.passwd-s3fs
#RUN chmod 600  ~/.passwd-s3fs
#RUN s3fs 41400a1a-a0f7d611-e456-4060-83d0-88849151493a /var/www/html/image -o use_path_request_style -o url=https://s3.timeweb.com -o passwd_file=~/.passwd-s3fs; exit 0

#RUN chown -R www-data:www-data /var/www/
#RUN chmod 755 -R /var/www/html/image

WORKDIR /var/www/html
