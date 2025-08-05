For this particular Image you have multiple options.

1. Some IDE's ([PHPStorm](https://intellij-support.jetbrains.com/hc/en-us/community/posts/14391537025170-PHPUnittests-via-docker-by-PHPStorm-Configuration) for example) have full support for docker unittesting, you just need to configure it there and
   you are good to go!

2. Run the tests from the cli. Execute the following cli commands (from within your Kohana installation folder):
   Start container in background and mount installation folder:

   ```shell
   docker stop unittest &&  docker rm unittest
   docker run -dtP --name unittest -v $(pwd):/tmp/kohana/ kohanaworld/docker:travis-devel-8.4
   ```

3. Start services, install composer requirements and run PHPUnit
   ```shell
   docker exec unittest /bin/sh -c "service redis-server start; service memcached start"
   docker exec -it unittest /bin/bash
   cd /tmp/kohana
   update-alternatives --config php
   # switch php version 
   rm composer.lock
   git config --global --add safe.directory /tmp/kohana
   composer install
   composer validate
   composer diagnose
   php -d opcache.jit=disable  vendor/bin/phpunit
   ```

_(Hint) You can execute a `/bin/bash` shell inside the container and modify it before Unit-Testing
```shell
docker exec -it unittest /bin/bash
cd /tmp/kohana
```
_(Hint) You can execute a single test
```shell
docker exec -it unittest /bin/bash
cd /tmp/kohana
composer install
php -d opcache.jit=disable  vendor/bin/phpunit   --filter HTMLTest
php -d opcache.jit=disable vendor/bin/phpunit   --filter HTMLTest --debug 
```
_




```shell
docker run -v $PWD:/app -p 80:80 -p 443:443 -p 443:443/udp --name=test -d  unit:1.32.1-php8.2

docker run -v $PWD:/app -p 80:80 -p 443:443 -p 443:443/udp --name=test -d  unit:1.32.1-php7.3

docker exec -it test bash


curl -X GET --unix-socket /var/run/control.unit.sock http://localhost/status
cd /app
curl -X PUT -d @unit.init.json  --unix-socket /var/run/control.unit.sock http://localhost/config/
```