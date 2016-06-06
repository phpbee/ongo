FROM php:5-fpm

RUN apt-get update 

RUN apt-get install -y php-pear git vim tree

RUN docker-php-ext-install mysqli mysqlnd pdo pdo_mysql    

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN mkdir -p -m 0777 /var/log/silex

