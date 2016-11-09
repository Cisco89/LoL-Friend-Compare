#!/bin/sh

sudo su
export DEBIAN_FRONTEND=noninteractive


apt install -y php php-mysql mysql-server nginx

mysql -e "CREATE DATABASE lol_friend_compare"

mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'developer'@'%' IDENTIFIED BY 'developer'"
