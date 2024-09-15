FROM webdevops/php-nginx:8.3


# Update the GPG key for the NGINX repository
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62

# Update package lists and install required packages
RUN apt-get update
# Install required PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set environment variables
ENV ROOT=/app
ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
ENV PHP_POST_MAX_SIZE 500M
ENV PHP_MAX_EXECUTION_TIME 300
ENV PHP_UPLOAD_MAX_FILESIZE 500M
ENV PHP_MEMORY_LIMIT 512M

# Set working directory and copy application code
WORKDIR /app
COPY ./ $ROOT

# Install dependencies
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist

# Composer update

RUN composer update


EXPOSE 80
