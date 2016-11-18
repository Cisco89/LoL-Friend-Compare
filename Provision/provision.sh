#!/bin/sh

sudo su
export DEBIAN_FRONTEND=noninteractive

echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list &&

wget https://www.dotdeb.org/dotdeb.gpg &&

apt-key add dotdeb.gpg &&

apt-get update &&

apt install -y aptitude vim php7.0 php7.0-mysql mysql-server mysql-client apache2 &&

mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'developer'@'%' IDENTIFIED BY 'developer'" &&

cp /vagrant/Provision/lol-friend-compare.conf /etc/apache2/sites-enabled/000-default.conf
