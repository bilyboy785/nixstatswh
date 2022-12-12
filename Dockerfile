FROM alpine:3.16
LABEL maintainer="contact@bouillaudmartin.fr"
LABEL description="Alpine based image with apache2 and php8 for Nixstats Webhook"

# Setup apache and php
RUN apk --no-cache --update \
    add apache2 \
    curl \
    php-apache2 \
    php-bcmath \
    php-bz2 \
    php-calendar \
    php-common \
    php-ctype \
    php-curl \
    php-dom \
    php-gd \
    php-iconv \
    php-mbstring \
    php-mysqli \
    php-mysqlnd \
    php-openssl \
    php-phar \
    php-session \
    php-xml \
    && mkdir /htdocs

EXPOSE 80 443

COPY ./sources/ /htdocs/

ADD docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

HEALTHCHECK CMD wget -q --no-cache --spider localhost

ENTRYPOINT ["/docker-entrypoint.sh"]