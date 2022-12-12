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
    php-openssl \
    php-phar \
    php-xml \
    php-json \
    && mkdir /htdocs

EXPOSE 80

COPY ./sources/ /htdocs/

ADD docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

HEALTHCHECK --interval=30s --timeout=3s --retries=3 CMD curl --fail http://localhost:80 || exit 1

ENTRYPOINT ["/docker-entrypoint.sh"]