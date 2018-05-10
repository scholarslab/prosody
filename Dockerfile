FROM wordpress:latest

# Install XSL
RUN apt-get update \
  && apt-get install -y libxslt-dev \
  && docker-php-ext-install -j$(nproc) xsl
