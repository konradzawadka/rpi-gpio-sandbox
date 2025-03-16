# Nginx and PHP-FPM Docker Setup

This project sets up an Nginx server with PHP-FPM using Docker. The configuration files are provided to ensure proper communication between Nginx and PHP-FPM.

## Prerequisites

- Docker installed on your machine

## Clone the repo

```sh
git clone https://github.com/konradzawadka/rpi-gpio-sandbox.git
cd rpi-gpio-sandbox
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

(run as root) To build the Docker image, run the following command:

```sh
docker build -t czujnik-server .
```

## Running the Docker Container

(run as root) To run the Docker container, use the following command:

```sh
docker run --privileged -p 8081:8081 czujnik-server -n czujnik-server
```


## Checking gpio status

(run as root) Enter to bash
```sh
sudo docker exec -it czujnik-server bash
gpio readall
```

set gpio 4 to out and then set status

```sh
gpio mode 4 OUT
gpio write 4 1
```

## Accessing the Application

Once the container is running, you can access the application by navigating to `http://{IP}:8081` in your web browser.

## Troubleshooting

### 502 Bad Gateway Error

If you encounter a 502 Bad Gateway error, ensure that both Nginx and PHP-FPM are running correctly inside the container. You can check the logs for more details:

```sh
docker exec -it <container_id> supervisorctl status
docker exec -it <container_id> tail -f /var/log/nginx.err
docker exec -it <container_id> tail -f /var/log/php-fpm.err
```