# Nginx and PHP-FPM Docker Setup

This project sets up an Nginx server with PHP-FPM using Docker. The configuration files are provided to ensure proper communication between Nginx and PHP-FPM.

## Prerequisites

- Docker installed on your machine

## Project Structure

```
.
├── Dockerfile
├── fastcgi-php.conf
├── index.php
├── nginx.conf
├── supervisord.conf
└── www.conf
```

## Configuration Files

### `nginx.conf`

This file configures Nginx to handle PHP requests and pass them to PHP-FPM.

### `fastcgi-php.conf`

This file includes FastCGI parameters and configurations for handling PHP requests.

### `www.conf`

This file configures PHP-FPM to listen on `127.0.0.1:9000`.

### `supervisord.conf`

This file configures Supervisor to manage both Nginx and PHP-FPM processes.

### `index.php`

A simple PHP file to test the setup.

## Building the Docker Image

To build the Docker image, run the following command:

```sh
docker build -t czujnik-server .
```

## Running the Docker Container

To run the Docker container, use the following command:

```sh
docker run --device /dev/gpiomem -p 8081:8081 czujnik-server
```

## Accessing the Application

Once the container is running, you can access the application by navigating to `http://localhost:8081` in your web browser.

## Troubleshooting

### 502 Bad Gateway Error

If you encounter a 502 Bad Gateway error, ensure that both Nginx and PHP-FPM are running correctly inside the container. You can check the logs for more details:

```sh
docker exec -it <container_id> supervisorctl status
docker exec -it <container_id> tail -f /var/log/nginx.err
docker exec -it <container_id> tail -f /var/log/php-fpm.err
```