docker rm -f db
docker run -d \
    --name db \
    -p 3333:3306 \
    -e MYSQL_ROOT_PASSWORD=1234 \
    -v $PWD/db:/var/lib/mysql \
    mariadb:10.5
