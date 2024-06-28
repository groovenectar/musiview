#!/usr/bin/env bash

# License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
# Homepage: https://c.dup.bz

# Source: https://obsproject.com/forum/resources/how-to-set-up-your-own-private-rtmp-server-using-nginx.50/

# OBS:
#Streaming Service: Custom
#Server: rtmp://<your server ip>/hls
#Play Path/Stream Key: test

# Stream available at http://localhost/hls/<stream key>.m3u8

apt-get install build-essential libpcre3 libpcre3-dev libssl-dev zlib1g-dev unzip
wget https://nginx.org/download/nginx-1.25.5.tar.gz
wget https://github.com/sergey-dryabzhinsky/nginx-rtmp-module/archive/dev.zip
tar -zxvf nginx-1.25.5.tar.gz
unzip dev.zip
cd nginx-1.25.5
./configure --with-http_ssl_module --add-module=../nginx-rtmp-module-dev
make
make install


# Start nginx
sudo /usr/local/nginx/sbin/nginx

# Restart ngins
sudo /usr/local/nginx/sbin/nginx -s stop
sudo /usr/local/nginx/sbin/nginx

/lib/systemd/system/nginx.service
