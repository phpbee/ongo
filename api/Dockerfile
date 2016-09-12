FROM php:5-fpm

RUN apt-get update 

RUN apt-get install -y php-pear 
RUN apt-get install -y git 
RUN apt-get install -y vim 
RUN apt-get install -y tree
RUN apt-get install -y supervisor

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd && \
      docker-php-ext-configure mysql --with-mysql=mysqlnd && \
      docker-php-ext-configure mysqli --with-mysqli=mysqlnd && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install mysqli && \
      docker-php-ext-install mysql

RUN apt-get install -y libz-dev libmemcached-dev gcc \
    && pecl install memcached \
    && docker-php-ext-enable memcached

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN mkdir -p -m 0777 /var/log/silex

ENV REEFER_VERSION v0.0.4
ENV SPLUNK_FORWARDER_VERSION 6.2.2
ENV SPLUNK_FORWARDER_BUILD 255606
ENV SPLUNK_FORWARDER_DEB_URL https://download.splunk.com/products/splunk/releases/${SPLUNK_FORWARDER_VERSION}/universalforwarder/linux/splunkforwarder-${SPLUNK_FORWARDER_VERSION}-${SPLUNK_FORWARDER_BUILD}-linux-2.6-amd64.deb

RUN curl --show-error ${SPLUNK_FORWARDER_DEB_URL} -o splunkforwarder.deb \
 && dpkg -i splunkforwarder.deb \
 && rm splunkforwarder.deb
RUN /opt/splunkforwarder/bin/splunk --accept-license enable boot-start
RUN /opt/splunkforwarder/bin/splunk add forward-server splunk:9997
RUN /opt/splunkforwarder/bin/splunk add monitor /var/log/silex/ -index main -sourcetype silex
RUN /opt/splunkforwarder/bin/splunk add monitor /var/log/ -index main -sourcetype system 


COPY src /var/www/src
COPY html /var/www/html
COPY vendor /var/www/vendor

COPY composer.* /var/www/
RUN cd /var/www && php composer.phar install


COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
