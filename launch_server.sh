#!/bin/sh
sudo nginx -c /Database_project/server.conf
sudo systemctl start php8.2-fpm
sudo chmod u+rw -R ../Database_project
sudo chmod 777 -R /var/run/php/
