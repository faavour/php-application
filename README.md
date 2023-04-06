# php-application-todo-app

This is a simple Todo app built with PHP and MySQLi and MongoDB. It is a Docker Compose-based PHP application for PHP-based todo-app application. It includes an Apache web server, a MySQL database server a MongoDB server, PHP application itself.

## Requirements

- Docker Engine
- Docker Compose

## Installation

1. Clone this repository or download the source code.
2. Run docker-compose build
3. Run docker-compose up


## Content Viewing
After running these steps, the Todo application can be viewed at http://localhost.
To view the mysql todoapp visit http://localhost/mysql
To view the mongodb todoapp visit http://localhost/mongodb






## INFRASTRUCTURE LAYOUT
    

![infrastructure-diagram](https://user-images.githubusercontent.com/95984978/230228227-a15d5660-dcb6-4dc9-92ce-865853c868fd.png)


Draw.io link :https://drive.google.com/file/d/1UcpCPyYnPl5KF_bSa3Kx0UwrSPaXRRvi/view?usp=sharing

By utilizing this architecture, the Todo app can continue to be highly available even if one or more components fail. The RDS instances provide automatic failover and recovery for the database, and the ALB makes sure that traffic is distributed fairly among the Web Frontend and API Backend instances.
