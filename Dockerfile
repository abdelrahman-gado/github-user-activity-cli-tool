FROM php:8.3-cli-alpine

WORKDIR /home/app

RUN apk add --no-cache \
    git \
    bash \
    unzip \
    && rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --no-interaction --optimize-autoloader

CMD ["tail", "-f", "/dev/null"]
