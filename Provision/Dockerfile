FROM php:5.6-apache

# Update and source packages
RUN apt-get update -y \
  && apt-get install -y \
  zlib1g-dev \
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  libapache2-mod-fcgid \
  libcurl4-gnutls-dev \
  libxml2-dev \
  supervisor \
  libmcrypt-dev \
  libjpeg62-turbo-dev \
  libvpx-dev \
  php5-fpm \
  php5-mysql \
  php5-curl \
  vim \
  awscli \
  redis-tools \
  && rm -rf /var/lib/apt/lists/*

# Phpize extensions
RUN docker-php-ext-install -j$(nproc) \
 pdo_mysql \
 gd \
 mysqli

# Get redis & xdebug from pecl
RUN pecl install \
  redis-2.2.8 \
  xdebug \
  && docker-php-ext-enable \
  redis \
  xdebug

# Enable apache mods
RUN a2enmod \
  headers \
  proxy \
  proxy_http \
  proxy_fcgi \
  rewrite \
  ssl \
  fcgid \
  include

# Prep directories
RUN mkdir /srv/logs
RUN chown www-data:www-data /srv -R
COPY . /opt/provision

RUN mkdir -p /srv/logs
RUN chown www-data:www-data /srv -R

# Move config files into place
RUN cp /opt/provision/apache/apache2.conf /etc/apache2/apache2.conf
RUN cp /opt/provision/apache/sites-enabled/lol-friend-compare.conf /etc/apache2/sites-enabled/lol-friend-compare.conf
RUN cp /opt/provision/apache/mods-available/fcgid.conf /etc/apache2/mods-available/fcgid.conf
# Move ssl cert chain
RUN mkdir -p /etc/pki/local
# Move fpm configs
RUN cp /opt/provision/fpm/pool.d/lol-friend-compare.conf /etc/php5/fpm/pool.d/lol-friend-compare.conf
RUN cp /opt/provision/fpm/php.ini /etc/php5/fpm/php.ini
RUN cat /opt/provision/fpm/conf.d/30-xdebug.ini | sed "s|_extensionFilePath|$(find /usr/local/lib/php/extensions/ -name 'xdebug.so')|g" > /etc/php5/fpm/conf.d/30-xdebug.ini
RUN cat /opt/provision/fpm/conf.d/30-redis.ini | sed "s|_extensionFilePath|$(find /usr/local/lib/php/extensions/ -name 'redis.so')|g" > /etc/php5/fpm/conf.d/30-redis.ini

CMD service php5-fpm start && service apache2 start && tail -f /var/log/apache2/error.log
