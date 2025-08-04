


```shell
docker run -v $PWD:/app -p 80:80 -p 443:443 -p 443:443/udp --name=test -d  unit:1.32.1-php8.2

docker run -v $PWD:/app -p 80:80 -p 443:443 -p 443:443/udp --name=test -d  unit:1.32.1-php7.3

docker exec -it test bash

curl -X GET --unix-socket /var/run/control.unit.sock http://localhost/status

curl -X PUT -d @unit.init.json  --unix-socket /var/run/control.unit.sock http://localhost/config/
```