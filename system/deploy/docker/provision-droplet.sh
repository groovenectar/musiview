#!/usr/bin/env bash

HOST1=c.dup.bz
HOST2=stream.dup.bz
HOST3=hq.dup.bz

# https://www.digitalocean.com/community/tutorials/how-to-setup-a-firewall-with-ufw-on-an-ubuntu-and-debian-cloud-server
ufw delete 6
ufw delete 5
ufw delete 3
ufw delete 2
ufw allow in http
ufw allow in https
ufw allow out https
ufw allow in 1936/tcp
ufw allow out 1935/tcp
ufw allow out ssh
ufw default deny outgoing

apt-get update
apt-get install -y certbot=1.21.0-1build1
# Need to disable firewall?
certbot certonly --non-interactive --agree-tos --standalone -m musiview@dup.bz -d $HOST1,$HOST2,$HOST3

ssh-keygen -f ~/.ssh/id_rsa.repo -N ''
ssh-copy-id -i ~/.ssh/id_rsa.repo dh_9gxnit@repo.dup.bz
ssh-keyscan -t rsa -H repo.dup.bz >> ~/.ssh/known_hosts

cd ~
GIT_SSH_COMMAND="ssh -i ~/.ssh/id_rsa.repo" git clone --origin repo ssh://dh_9gxnit@repo.dup.bz/~/repo/musiview

mkdir -p ~/musiview/system/deploy/docker/musiview-web/cert/$HOST1
mkdir -p ~/musiview/system/deploy/docker/musiview-streaming/cert/$HOST2
mkdir -p ~/musiview/system/deploy/docker/musiview-web/cert/$HOST3

cp -f /etc/letsencrypt/archive/$HOST1/fullchain1.pem ~/musiview/system/deploy/docker/musiview-web/cert/$HOST1/fullchain.pem
cp -f /etc/letsencrypt/archive/$HOST1/privkey1.pem ~/musiview/system/deploy/docker/musiview-web/cert/$HOST1/privkey.pem
cp -f /etc/letsencrypt/archive/$HOST2/fullchain1.pem ~/musiview/system/deploy/docker/musiview-streaming/cert/$HOST2/fullchain.pem
cp -f /etc/letsencrypt/archive/$HOST2/privkey1.pem ~/musiview/system/deploy/docker/musiview-streaming/cert/$HOST2/privkey.pem
cp -f /etc/letsencrypt/archive/$HOST3/fullchain1.pem ~/musiview/system/deploy/docker/musiview-web/cert/$HOST3/fullchain.pem
cp -f /etc/letsencrypt/archive/$HOST3/privkey1.pem ~/musiview/system/deploy/docker/musiview-web/cert/$HOST3/privkey.pem

chmod 644 ~/musiview/system/deploy/docker/musiview-web/cert/$HOST1/fullchain.pem
chmod 644 ~/musiview/system/deploy/docker/musiview-web/cert/$HOST1/privkey.pem
chmod 644 ~/musiview/system/deploy/docker/musiview-streaming/cert/$HOST2/fullchain.pem
chmod 644 ~/musiview/system/deploy/docker/musiview-streaming/cert/$HOST2/privkey.pem
chmod 644 ~/musiview/system/deploy/docker/musiview-web/cert/$HOST3/fullchain.pem
chmod 644 ~/musiview/system/deploy/docker/musiview-web/cert/$HOST3/privkey.pem

useradd --create-home collection
usermod -a -G collection www-data

# Temp mount:
mount --bind /home/collection/folder /root/musiview/collection
# Make it permanent like this:
#https://askubuntu.com/a/763645
#In /etc/fstab
#/home/collection/folder   /root/musiview/collection   none   bind   0 0

apt-get install -y docker-compose-plugin=2.27.0-1~ubuntu.22.04~jammy

cd ~/musiview/system/deploy/docker/musiview-web
docker compose up -d

apt install fail2ban
cd /etc/fail2ban
cp jail.conf jail.local
# Open file and add enabled=true to various services, some might give errors about log
systemctl enable fail2ban
systemctl start fail2ban
# Double check
systemctl status fail2ban
