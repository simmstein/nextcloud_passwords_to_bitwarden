FROM deblan/php:8.3

WORKDIR /app

COPY . .

RUN composer install

ENTRYPOINT ["php", "index.php"]
