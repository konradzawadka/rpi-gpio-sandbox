# Use the official Nginx image as a base
FROM nginx:latest

# Install PHP and necessary extensions
RUN apt-get update && \
    apt-get install -y php-fpm php-mysql supervisor && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*


# Copy the Nginx configuration file
COPY nginx.conf /etc/nginx/nginx.conf

# Copy the PHP file to the web root
COPY index.php /usr/share/nginx/html/index.php
COPY fastcgi-php.conf /etc/nginx/fastcgi-php.conf
COPY www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 80
EXPOSE 80

# Start Nginx and PHP-FPM
CMD service php8.2-fpm start && nginx -g "daemon off;"
