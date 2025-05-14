FROM hyperf/hyperf:8.3-alpine-v3.19-swoole

RUN apk update \
    && apk add --no-cache autoconf gcc make g++ linux-headers bash \
    && apk add --no-cache php83-dev php83-pear \
    && apk add --no-cache php83-pecl-xdebug \
    && echo "zend_extension=$(find /usr/lib -name xdebug.so)" > /etc/php83/conf.d/xdebug.ini

WORKDIR /data/project

COPY . .
