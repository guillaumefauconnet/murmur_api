#!/bin/bash

#vider le fichier de log de xdebug
truncate -s 0 /var/www/api/docker/logs/xdebug.log

cd /var/www/api || exit
symfony server:stop
symfony server:start
#php -S localhost:8000
