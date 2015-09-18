#!/bin/sh

host="localhost"
db="eoh"
usr="root"
pwd='mysql'

echo "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8 COLLATE utf8_general_ci;" | /usr/bin/mysql -u$usr -p$pwd

php insert.php $host $db $usr $pwd
