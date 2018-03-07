FROM php:7.1-fpm
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN apt-get update && \
    apt-get install -y \
        nano \
        libmcrypt-dev \
        libxml2-dev \
        icu-devtools \
        libicu-dev \
        g++ \
        ca-certificates \
        curl \
        wget \
        zlib1g-dev \
        && \
    rm -rf /var/lib/apt/lists/*

RUN pecl update-channels && \
    pecl install xdebug ds && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-enable --ini-name 20-ds.ini ds

RUN docker-php-ext-install -j$(nproc) \
    json \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer
ARG TARGET_GID
ENV TARGET_GID=$TARGET_GID
COPY permissions.sh /

RUN chmod +x /permissions.sh && bash /permissions.sh

RUN echo 'alias ll="ls -lahk --color=auto"' >> ~/.bashrc

WORKDIR /var/www/html
ENV DEBIAN_FRONTEND teletype