FROM php:8.0-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

ENV PYTHONIOENCODING utf-8

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install git unzip libzip-dev libicu-dev libonig-dev wget gcc make zlib1g-dev libssl-dev libmecab2 libmecab-dev mecab mecab-ipadic mecab-ipadic-utf8 mecab-utils locales && \
  apt-get clean && \
  locale-gen ja_JP.UTF-8 && \
  echo "export LANG=ja_JP.UTF-8" >> ~/.bashrc && \
  wget https://www.python.org/ftp/python/3.6.1/Python-3.6.1.tgz && \
  tar zxvf Python-3.6.1.tgz && \
  cd Python-3.6.1 && \
  ./configure --prefix=/usr/local/python && \
  make && make install && \
  ln -s /usr/local/python/bin/python3.6 /usr/local/bin/python && \
  ln -s /usr/local/python/bin/pip3.6 /usr/local/bin/pip && \
  pip install --upgrade pip setuptools mecab-python3 oseti tweepy python-dotenv && \
  cp /etc/mecabrc /usr/local/etc/ && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  localedef -f UTF-8 -i ja_JP ja_JP.UTF-8 && \
  composer require abraham/twitteroauth

COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /work