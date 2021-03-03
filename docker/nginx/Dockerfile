FROM nginx:stable as viator_nginx

RUN rm -rf /etc/nginx/conf.d/default.conf/template

COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.template

WORKDIR /var/www/html

CMD ["/bin/sh","-c","envsubst '\\${API_HOST}' < /etc/nginx/conf.d/default.template > /etc/nginx/conf.d/default.conf && exec nginx -g 'daemon off;'"]
