FROM php:8.2-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80 1883
WORKDIR /app
COPY app/ /app/

# git, unzip & zip are for composer
RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    python3 \
    python3-pip \
    python3-venv \
    zip &&\
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Création et activation d'un environnement virtuel Python
RUN python3 -m venv /venv
ENV PATH="/venv/bin:$PATH"

# Installation de paho-mqtt dans l'environnement virtuel
RUN pip install paho-mqtt 
RUN pip install mysql-connector-python

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini



# Apache
COPY errors /errors
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf

RUN a2enmod rewrite remoteip && \
    a2enconf z-app

# On lance le script de connexion au broker MQTT MARCHE PAS
CMD ["python3", "/app/mqtttest.py"]