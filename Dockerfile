FROM crsitianpuas32/sisweb_cubi:latest




COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

WORKDIR /app
COPY . .
RUN rm -rf /app/vendor
RUN rm -rf /app/composer.lock
RUN composer install
RUN composer require laravel/octane spiral/roadrunner
RUN chown -R www-data:www-data /app/storage
COPY .env.example .env
RUN mkdir -p /app/storage/logs
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan config:clear
RUN php artisan octane:install --server="swoole"
CMD php artisan octane:start --server="swoole" --host="0.0.0.0"

EXPOSE 8000