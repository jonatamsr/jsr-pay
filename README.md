# Jsr Pay

A project designed for monetary transfers with Laravel 11, PostgreSQL, NGinx and Docker.

## Requirements
- docker
- docker-compose

## Setup

After cloning the project, in the root project directory in the terminal:

1. `cd .docker`
2. `docker-compose up -d`
3. `docker-compose exec api composer install`
4. `docker-compose exec api php artisan migrate --seed`

## Run Tests

Developing...

## Contributing

@author: Jonatam de Sousa Rocha (jonatamsr@gmail.com)
