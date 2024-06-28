#!/usr/bin/env bash

apt install ca-certificates apt-transport-https software-properties-common lsb-release -y
add-apt-repository ppa:ondrej/php -y
apt update
apt install php8.2 php8.2-fpm php8.2-cli

systemctl start php8.2-fpm
