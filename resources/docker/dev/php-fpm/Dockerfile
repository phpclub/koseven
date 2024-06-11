FROM kohanaworld/docker:travis-devel

RUN apt-get update && apt-get install -y iputils-ping

RUN service redis-server start && service memcached start

#COPY . /tmp/koseven

#WORKDIR /tmp/koseven

#RUN

#RUN cd /tmp/koseven \
#    rm -f composer.lock \
#    && php -v \
#    && composer install \
#    && echo 'php vendor/bin/phpunit --bootstrap=modules/unittest/bootstrap.php modules/unittest/tests.php' > tests.sh \
#    && chmod +x php -tests.sh

WORKDIR /var/www