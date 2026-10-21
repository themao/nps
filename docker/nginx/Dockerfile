FROM nginx:1.28-alpine

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf
COPY sites-available/app.conf /etc/nginx/conf.d/app.conf
