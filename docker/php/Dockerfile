FROM php:7-fpm

RUN apt-get update

RUN docker-php-ext-install \
	pdo_mysql

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		git \
		libzip-dev \
		zip \
		nano \
	&& docker-php-ext-install -j$(nproc) iconv \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd \
	&& docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install bcmath




RUN apt-get update && apt-get install -y --fix-missing \
    apt-utils \
    gnupg

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

RUN curl -sS https://docker-hosting.srv.mhp.com.ua/getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version