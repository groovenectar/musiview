#!/usr/bin/env bash

# License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
# Homepage: https://c.dup.bz

# Source: https://obsproject.com/forum/resources/how-to-set-up-your-own-private-rtmp-server-using-nginx.50/

# OBS:
#Streaming Service: Custom
#Server: rtmp://<your server ip>/hls
#Play Path/Stream Key: test

# Stream available at http://localhost/hls/<stream key>.m3u8


mkdir /tmp/hls

# Add to end of file:

# https://github.com/arut/nginx-rtmp-module/wiki/Directives
#rtmp {
#        server {
#                listen 1935;
#                chunk_size 4096;
#
#                application live {
#                        live on;
#                        record off;
#                        #Can add multiple
#                        #https://help.twitch.tv/s/twitch-ingest-recommendation
#                        #push rtmp://<other streaming service rtmp url>/<stream key>
#                }
#        }
#}

# Start nginx
sudo /usr/local/nginx/sbin/nginx

# Restart ngins
sudo /usr/local/nginx/sbin/nginx -s stop
sudo /usr/local/nginx/sbin/nginx
