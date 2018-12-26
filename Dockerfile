FROM alpine:3.8

MAINTAINER "1giba" <olamundo@gmail.com>

#
#--------------------------------------------------------------------------
# Libs
#--------------------------------------------------------------------------
#
RUN apk --update add ca-certificates bash curl shadow tzdata

#
#--------------------------------------------------------------------------
# User
#--------------------------------------------------------------------------
#

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
ARG USER=docker
ENV USER ${USER}

RUN addgroup -g ${PGID} ${USER} && \
    adduser -u ${PUID} -h /home/${USER} -D -G ${USER} ${USER} && \
    chown -R ${USER}:${USER} /home/${USER}

#
#--------------------------------------------------------------------------
# PHP Install
#--------------------------------------------------------------------------
#
ADD https://php.codecasts.rocks/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
RUN echo "@php https://php.codecasts.rocks/v3.8/php-7.2" >> /etc/apk/repositories
RUN apk add --update php@php \
    php-common@php \
    php-curl@php \
    php-ctype@php \
    php-phpdbg@php \
    php-dev@php \
    php-fpm@php \
    php-iconv@php \
    php-json@php \
    php-mbstring@php \
    php-openssl@php \
    php-pdo@php \
    php-pdo_mysql@php \
    #php-pdo_pgsql@php \
    php-pdo_sqlite@php \
    php-phar@php \
    php-session@php \
    php-xml@php \
    php-xmlreader@php \
    php-zip@php \
    php-zlib@php

RUN ln -sf /usr/bin/php7 /usr/bin/php && \
    ln -sf /usr/sbin/php-fpm7 /usr/bin/php-fpm

#
#--------------------------------------------------------------------------
# PHP Configs
#--------------------------------------------------------------------------
#
ENV PHP_FPM_USER www
ENV PHP_FPM_GROUP www
ENV PHP_FPM_LISTEN_MODE 0660
ENV PHP_MEMORY_LIMIT 512M
ENV PHP_MAX_UPLOAD 50M
ENV PHP_MAX_FILE_UPLOAD 200
ENV PHP_MAX_POST 100M
ENV PHP_DISPLAY_ERRORS On
ENV PHP_DISPLAY_STARTUP_ERRORS On
ENV PHP_ERROR_REPORTING "E_COMPILE_ERROR\|E_RECOVERABLE_ERROR\|E_ERROR\|E_CORE_ERROR"
ENV PHP_CGI_FIX_PATHINFO 0
ENV TIMEZONE UTC

RUN sed -i "s|;listen.owner\s*=\s*nobody|listen.owner = ${PHP_FPM_USER}|g" /etc/php7/php-fpm.d/www.conf && \
    sed -i "s|;listen.group\s*=\s*nobody|listen.group = ${PHP_FPM_GROUP}|g" /etc/php7/php-fpm.d/www.conf && \
    sed -i "s|;listen.mode\s*=\s*0660|listen.mode = ${PHP_FPM_LISTEN_MODE}|g" /etc/php7/php-fpm.d/www.conf && \
    sed -i "s|user\s*=\s*nobody|user = ${PHP_FPM_USER}|g" /etc/php7/php-fpm.d/www.conf && \
    sed -i "s|group\s*=\s*nobody|group = ${PHP_FPM_GROUP}|g" /etc/php7/php-fpm.d/www.conf && \
    sed -i "s|;log_level\s*=\s*notice|log_level = notice|g" /etc/php7/php-fpm.conf && \
    sed -i "s|display_errors\s*=\s*Off|display_errors = ${PHP_DISPLAY_ERRORS}|i" /etc/php7/php.ini && \
    sed -i "s|display_startup_errors\s*=\s*Off|display_startup_errors = ${PHP_DISPLAY_STARTUP_ERRORS}|i" /etc/php7/php.ini && \
    sed -i "s|error_reporting\s*=\s*E_ALL & ~E_DEPRECATED & ~E_STRICT|error_reporting = ${PHP_ERROR_REPORTING}|i" /etc/php7/php.ini && \
    sed -i "s|;*memory_limit =.*|memory_limit = ${PHP_MEMORY_LIMIT}|i" /etc/php7/php.ini && \
    sed -i "s|;*upload_max_filesize =.*|upload_max_filesize = ${PHP_MAX_UPLOAD}|i" /etc/php7/php.ini && \
    sed -i "s|;*max_file_uploads =.*|max_file_uploads = ${PHP_MAX_FILE_UPLOAD}|i" /etc/php7/php.ini && \
    sed -i "s|;*post_max_size =.*|post_max_size = ${PHP_MAX_POST}|i" /etc/php7/php.ini && \
    sed -i "s|;*cgi.fix_pathinfo=.*|cgi.fix_pathinfo= ${PHP_CGI_FIX_PATHINFO}|i" /etc/php7/php.ini

RUN rm -rf /etc/localtime \
    && ln -s /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && sed -i "s|;*date.timezone =.*|date.timezone = ${TIMEZONE}|i" /etc/php7/php.ini

#
#--------------------------------------------------------------------------
# Composer
#--------------------------------------------------------------------------
#
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer  \
    && composer global require "hirak/prestissimo:^0.3"

#
#--------------------------------------------------------------------------
# Node & Yarn
#--------------------------------------------------------------------------
#
RUN apk add --update nodejs-npm yarn

#
#--------------------------------------------------------------------------
# Nginx
#--------------------------------------------------------------------------
#
RUN apk --update add nginx && \
    rm /etc/nginx/conf.d/default.conf

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# Add user to Nginx
RUN adduser -D -g www www && \
    sed -i "s/user nginx;/user www;/g" /etc/nginx/nginx.conf && \
    usermod -a -G www ${USER}

# Add vhost
ADD ./storage/docker/nginx/vhost.example /etc/nginx/conf.d/vhost.conf

# PID
RUN mkdir -p /run/nginx && \
    touch /run/nginx/nginx.pid && \
    chown www:www /run/nginx/nginx.pid  && \
    chown -R www:www /var/lib/nginx

#
#--------------------------------------------------------------------------
# Supervisor
#--------------------------------------------------------------------------
#
RUN apk --update add supervisor && \
    mkdir -p /etc/supervisor.d
ADD ./storage/docker/supervisor/default.ini /etc/supervisor.d/

#
#--------------------------------------------------------------------------
# App configuration
#--------------------------------------------------------------------------
#
ARG APP_PATH="/var/www/html/laravel"
ENV APP_PATH ${APP_PATH}
RUN mkdir -p ${APP_PATH} && \
    chown -R www:www ${APP_PATH}
ARG APP_URL="your-app.url"
ENV APP_URL ${APP_URL}
RUN sed -i "s|your-app.url|${APP_URL}|" /etc/nginx/conf.d/vhost.conf && \
    sed -i "s|/var/www/html/laravel|${APP_PATH}|" /etc/nginx/conf.d/vhost.conf

WORKDIR ${APP_PATH}

#
#--------------------------------------------------------------------------
# Clear
#--------------------------------------------------------------------------
#
RUN rm -rf /var/cache/apk/* /tmp/* /usr/share/man

#
#--------------------------------------------------------------------------
# Runs supervisor
#--------------------------------------------------------------------------
#
EXPOSE 80 443

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
