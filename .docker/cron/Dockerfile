FROM php:8.2-fpm
WORKDIR /var
RUN apt-get update && apt-get install -y cron libpq-dev libpng-dev libzip-dev zip
RUN docker-php-ext-install pgsql pdo_pgsql gd zip\
&& docker-php-ext-enable opcache

# Add docker custom crontab
ADD .docker/cron/laravel_docker_crontab /etc/cron.d/laravel_docker_crontab

# Specify crontab file for running
RUN crontab /etc/cron.d/laravel_docker_crontab
# execute crontab
CMD ["cron", "-f"]
