FROM yiisoftware/yii2-php:7.1-fpm
RUN apt-get update
RUN apt-get install -y zip
RUN docker-php-ext-install pdo pdo_pgsql pgsql

#COMPOSER 
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
