For this particular Image you have multiple options.

1. Some IDE's ([PHPStorm](https://intellij-support.jetbrains.com/hc/en-us/community/posts/14391537025170-PHPUnittests-via-docker-by-PHPStorm-Configuration) for example) have full support for docker unittesting, you just need to configure it there and
   you are good to go!

2. Run the tests from the cli. Execute the following cli commands (from within your Kohana installation folder):
   Start container in background and mount installation folder:

   ```shell
   docker stop unittest &&  docker rm unittest
   docker run -dtP --name unittest -v $(pwd):/tmp/koseven/ kohanaworld/docker:travis-devel-8.4
   ```

3. Start services, install composer requirements and run PHPUnit
   ```shell
   docker exec unittest /bin/sh -c "service redis-server start; service memcached start"
   docker exec -it unittest /bin/bash
   cd /tmp/koseven
   #update-alternatives --config php
   update-alternatives --set php /usr/bin/php8.4 
   # switch php version 
   rm composer.lock memory 
   git config --global --add safe.directory /tmp/koseven
   composer validate
   composer diagnose
   composer install
   # Disable xdebug 
   mv /etc/php/8.4/cli/conf.d/20-xdebug.ini /etc/php/8.4/cli/conf.d/20-xdebug.ini.disabled
   php -d opcache.jit=1 -d opcache.jit_buffer_size=10000  vendor/bin/phpunit
   CTL-D
   docker exec unittest /bin/sh -c "service redis-server stop; service memcached stop"
   docker stop unittest &&  docker rm unittest
   ```

_(Hint) You can execute a `/bin/bash` shell inside the container and modify it before Unit-Testing
```shell
docker exec -it unittest /bin/bash
cd /tmp/koseven
```
_(Hint) You can execute a single test
```shell
docker exec -it unittest /bin/bash
cd /tmp/koseven
composer install
php -d opcache.jit=0 -d opcache.jit_buffer_size=0  vendor/bin/phpunit   --filter HTMLTest
php -d opcache.jit=0 -d opcache.jit_buffer_size=0   --filter HTMLTest --debug 
```
_



Work with Unix Nginx https://unit.nginx.org/
```shell
# Start PHP 8.4 
docker run -v $PWD:/app -p 80:80 -p 443:443 -p 443:443/udp --name=test -d  kohanaworld/unit:1.34.2-php8.4
# # Start PHP 7.3 
#docker run -v $PWD:/app -p 80:80 -p 443:443 -p 443:443/udp --name=test -d  kohanaworld/unit:1.34.2-php7.3
docker exec -it test bash
curl -X GET --unix-socket /var/run/control.unit.sock http://localhost/status
cd /app
curl -X PUT -d @unit.init.json  --unix-socket /var/run/control.unit.sock http://localhost/config/
chmod -R 777 application/logs/
curl http://localhost/
```