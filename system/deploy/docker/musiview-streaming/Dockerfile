FROM ubuntu:mantic-20240427

EXPOSE 8080
EXPOSE 4443
EXPOSE 1936

# Update package cache
RUN apt-get update

# Set timezone
RUN echo UTC > /etc/timezone && ln -fs /usr/share/zoneinfo/Etc/UTC /etc/localtime
RUN apt-get install -y tzdata
RUN dpkg-reconfigure --frontend noninteractive tzdata

# Install PHP-FPM
RUN apt-get install -y php8.2-fpm=8.2.10-2ubuntu2.1

# Install Nginx
RUN apt-get install -y nginx=1.24.0-1ubuntu1

# Install Nginx module
RUN cd ~ \
    && apt-get install -y build-essential libpcre3-dev libssl-dev zlib1g-dev wget unzip \
	&& wget https://nginx.org/download/nginx-1.24.0.tar.gz \
	&& wget https://github.com/sergey-dryabzhinsky/nginx-rtmp-module/archive/dev.zip \
	&& tar -zxvf nginx-1.24.0.tar.gz \
	&& unzip dev.zip \
	&& cd nginx-1.24.0 \
	&& ./configure --add-dynamic-module=../nginx-rtmp-module-dev --with-compat \
	&& make modules \
	&& cp objs/ngx_rtmp_module.so /etc/nginx/modules-available/ngx_rtmp_module.so \
	&& ln -s /etc/nginx/modules-available/ngx_rtmp_module.so /etc/nginx/modules-enabled/ngx_rtmp_module.so
RUN cd ~ \
	&& rm -r nginx-1.24.0 \
	&& rm -r nginx-rtmp-module-dev \
	&& rm nginx-1.24.0.tar.gz dev.zip \
	&& apt-get remove -y build-essential libpcre3-dev libssl-dev zlib1g-dev wget unzip

# Install ffmpeg
RUN apt-get install -y ffmpeg=7:6.0-6ubuntu1

# Copy Nginx config
COPY ../../../../../system/deploy/docker/musiview-streaming/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy RTMP auth script
COPY ../../../../../system/deploy/docker/musiview-streaming/on-publish.php /app/system/deploy/docker/musiview-streaming/on-publish.php
COPY ../../../../../system/deploy/docker/musiview-streaming/status.php /app/system/deploy/docker/musiview-streaming/status.php

# Start Nginx
CMD /etc/init.d/php8.2-fpm start -F && nginx -g "daemon off;"
