#!/bin/sh
sudo nginx -s stop
sudo nginx -c /Database_project/server.conf
sudo systemctl start php7.4-fpm
sudo systemctl start mariadb
sudo chmod 777 -R /var/run/php
sudo chmod 777 -R /Database_project
