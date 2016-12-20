# lol-friend-compare

## Setup host file
`192.168.50.200 lol-friend-compare.local`

## Install Docker Compose Vagrant plugin:
`vagrant plugin install vagrant-docker-compose`

## Rebuild Docker Containers
Additionally will build database from base.sql file

```
docker-compose stop && \
yes | docker-compose rm && \
docker-compose pull && \
docker-compose build && \
docker-compose create && \
docker-compose start
```
