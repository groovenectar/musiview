FROM ubuntu:mantic-20240427

EXPOSE 80
EXPOSE 443

# Update package cache
RUN apt-get update

# Set timezone
RUN echo UTC > /etc/timezone && ln -fs /usr/share/zoneinfo/Etc/UTC /etc/localtime
RUN apt-get install -y tzdata
RUN dpkg-reconfigure --frontend noninteractive tzdata

# Install PHP and required dependencies
RUN apt-get install -y php8.2-fpm=8.2.10-2ubuntu2.1 php8.2-cli=8.2.10-2ubuntu2.1 php8.2-gd=8.2.10-2ubuntu2.1 php8.2-curl=8.2.10-2ubuntu2.1 php8.2-xml=8.2.10-2ubuntu2.1 php8.2-mbstring=8.2.10-2ubuntu2.1

# Install Nginx
RUN apt-get install -y nginx=1.24.0-1ubuntu1

# Install ffmpeg
RUN apt-get install -y ffmpeg=7:6.0-6ubuntu1

# Copy app files
COPY ../../../../.. /app/
VOLUME /app/collection

RUN apt-get install -y composer=2.5.8-1

RUN cd /app/module/Lipupini && composer install --no-interaction --no-dev --prefer-dist
RUN cd /app/module/Musiview && composer install --no-interaction --no-dev --prefer-dist

RUN apt-get remove -y composer

# Copy Nginx config
RUN ln -sf /app/system/deploy/docker/musiview-web/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy PHP pool config
RUN ln -sf /app/system/deploy/docker/musiview-web/php/www.conf /etc/php/8.2/fpm/pool.d/www.conf

# Webserver user to webroot
RUN chown -R www-data: /app/module/Musiview/webroot
# Directory permissions
RUN find /app/collection -type d -exec chmod 775 {} +
# File permissions
RUN find /app/collection -type f -exec chmod 665 {} +
# File and directory owner:group
RUN chown -R 1000:1000 /app/collection
RUN chown -R 1000:1000 /app/module/Lipupini/ActivityPub/cache
RUN chown -R 1000:1000 /app/module/Musiview/webroot/c

# Link repo key
#RUN mkdir -p ~/.ssh && ln -s /run/secrets/repo_ssh_key ~/.ssh/id_rsa.repo
#RUN ssh-keyscan -t rsa -H repo.dup.bz >> ~/.ssh/known_hosts

# Start PHP and Nginx
CMD /etc/init.d/php8.2-fpm start -F && nginx -g "daemon off;"
