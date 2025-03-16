FROM nginx:latest

# Install PHP and necessary extensions
RUN apt-get update && \
    apt-get install -y php-fpm php-mysql supervisor git build-essential sudo && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Install WiringPi from source
RUN git clone https://github.com/WiringPi/WiringPi.git /tmp/WiringPi && \
    cd /tmp/WiringPi && \
    ./build && \
    cd / && \
    rm -rf /tmp/WiringPi



# Copy configuration files
COPY nginx.conf /etc/nginx/nginx.conf
COPY index.php /usr/share/nginx/html/index.php
COPY style.css /usr/share/nginx/html/style.css
COPY fastcgi-php.conf /etc/nginx/fastcgi-php.conf
COPY www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf



# Start services using supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]