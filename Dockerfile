FROM php:8.3-apache
# Allow rewrite
RUN a2enmod rewrite

# Install Maria DB and Nano
RUN apt-get update -y && apt-get install -y libmariadb-dev nano
# Install PDO
RUN docker-php-ext-install pdo pdo_mysql

# MAKE MAIL() WORK USING MAILHOG
# Install Git, Go and mhsendmail SMTP client for Mailhog
# Access Mailhog: http://localhost:8025
# https://phauer.com/2017/test-mail-server-php-docker-container/
# Install Git
RUN apt-get update &&\
    apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*
# Install Go
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
# Install mhsendmail
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail
# Edit php.ini to use mailhog as SMTP server
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025' > /usr/local/etc/php/php.ini

# COMPOSER
# Allow root/superuser to run composer
ENV COMPOSER_ALLOW_SUPERUSER=1
# Install Zip to use Composer
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip
# Install and update Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update

WORKDIR /var/www/html
COPY . .