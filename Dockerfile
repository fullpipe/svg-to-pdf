FROM webdevops/php-nginx:7.3

ENV WEB_DOCUMENT_ROOT /app/public
WORKDIR /app
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install

COPY . .
