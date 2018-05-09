FROM wordpress:latest

# Install XSL
RUN apt-get update \
  && apt-get install -y libxslt-dev \
  && docker-php-ext-install -j$(nproc) xsl

#COPY docker-entrypoint.sh /usr/local/bin/
#COPY docker-entrypoint.sh /
#
#ENTRYPOINT ["docker-entrypoint.sh"]
