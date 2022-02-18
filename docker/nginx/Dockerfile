FROM nginx

RUN apt-get update \
    && apt-get install -y vim nano

COPY docker/nginx/cert/localhost.crt /etc/nginx/localhost.crt
COPY docker/nginx/cert/localhost.decrypted.key /etc/nginx/localhost.key

#COPY docker/nginx/default-site.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
