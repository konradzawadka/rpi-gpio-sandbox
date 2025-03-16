# Nginx and PHP-FPM Docker Setup

This project sets up an Nginx server with PHP-FPM using Docker. The configuration files are provided to ensure proper communication between Nginx and PHP-FPM.

## Prerequisites

- Docker and git installed on your machine

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
docker run --privileged -p 8081:8081 --name czujnik-server czujnik-server 
```


## Checking gpio status

(run as root) Enter to bash
```sh
sudo docker exec -it czujnik-server bash
gpio readall
```

The output will be:

```
 +-----+-----+---------+------+---+---Pi 5---+---+------+---------+-----+-----+
 | BCM | wPi |   Name  | Mode | V | Physical | V | Mode | Name    | wPi | BCM |
 +-----+-----+---------+------+---+----++----+---+------+---------+-----+-----+
 |     |     |    3.3v |      |   |  1 || 2  |   |      | 5v      |     |     |
 |   2 |   8 |   SDA.1 |   -  | 0 |  3 || 4  |   |      | 5v      |     |     |
 |   3 |   9 |   SCL.1 |   -  | 0 |  5 || 6  |   |      | 0v      |     |     |
 |   4 |   7 | GPIO. 7 |   -  | 0 |  7 || 8  | 0 |  -   | TxD     | 15  | 14  |
 |     |     |      0v |      |   |  9 || 10 | 0 |  -   | RxD     | 16  | 15  |
 |  17 |   0 | GPIO. 0 |   -  | 0 | 11 || 12 | 0 |  -   | GPIO. 1 | 1   | 18  |
 |  27 |   2 | GPIO. 2 |   -  | 0 | 13 || 14 |   |      | 0v      |     |     |
 |  22 |   3 | GPIO. 3 |   -  | 0 | 15 || 16 | 1 | OUT  | GPIO. 4 | 4   | 23  |
 |     |     |    3.3v |      |   | 17 || 18 | 0 |  -   | GPIO. 5 | 5   | 24  |
 |  10 |  12 |    MOSI |   -  | 0 | 19 || 20 |   |      | 0v      |     |     |
 |   9 |  13 |    MISO |   -  | 0 | 21 || 22 | 0 |  -   | GPIO. 6 | 6   | 25  |
 |  11 |  14 |    SCLK |   -  | 0 | 23 || 24 | 0 |  -   | CE0     | 10  | 8   |
 |     |     |      0v |      |   | 25 || 26 | 0 |  -   | CE1     | 11  | 7   |
 |   0 |  30 |   SDA.0 |   IN | 1 | 27 || 28 | 1 | IN   | SCL.0   | 31  | 1   |
 |   5 |  21 | GPIO.21 |   -  | 0 | 29 || 30 |   |      | 0v      |     |     |
 |   6 |  22 | GPIO.22 |   -  | 0 | 31 || 32 | 0 |  -   | GPIO.26 | 26  | 12  |
 |  13 |  23 | GPIO.23 |   -  | 0 | 33 || 34 |   |      | 0v      |     |     |
 |  19 |  24 | GPIO.24 |   -  | 0 | 35 || 36 | 0 |  -   | GPIO.27 | 27  | 16  |
 |  26 |  25 | GPIO.25 |   -  | 0 | 37 || 38 | 0 |  -   | GPIO.28 | 28  | 20  |
 |     |     |      0v |      |   | 39 || 40 | 0 |  -   | GPIO.29 | 29  | 21  |
 +-----+-----+---------+------+---+----++----+---+------+---------+-----+-----+
 | BCM | wPi |   Name  | Mode | V | Physical | V | Mode | Name    | wPi | BCM |
 +-----+-----+---------+------+---+---Pi 5---+---+------+---------+-----+-----+

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