#!/usr/bin/env bash

# License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
# Homepage: https://c.dup.bz

#server {
#    server_name tunnel.yourdomain;
#
#    access_log /var/log/nginx/$host;
#
#    location / {
#	      proxy_pass http://localhost:3333/;
#	      proxy_set_header X-Real-IP $remote_addr;
#	      proxy_set_header Host $host;
#	      proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
#       proxy_set_header X-Forwarded-Proto https;
#	      proxy_redirect off;
#    }
#
#    error_page 502 /50x.html;
#    location = /50x.html {
#	    root /usr/share/nginx/html;
#    }
#}

# On local machine:
ssh -R 3333:localhost:4000 user@t.dup.bz
