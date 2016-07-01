FROM nginx

COPY nginx.conf /etc/nginx/conf.d/default.template

COPY dist /var/www/html

CMD /bin/bash -c "envsubst '\$ASSETS_CDN' < /etc/nginx/conf.d/default.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"
