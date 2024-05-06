# Jsr Pay

A project designed for monetary transfers with Laravel 11, PostgreSQL, NGinx and Docker.

## Requirements
- docker
- docker-compose

## Setup

Clone the project

```bash
  git clone https://github.com/jonatamsr/jsr-pay.git
```

Go to the project docker files directory

```bash
  cd jsr-pay/.docker
```

Start the containers

```bash
  docker-compose up -d
```

Install the dependencies

```bash
  docker-compose exec composer install
```

Migrate the database with seeds

```bash
  docker-compose exec php artisan migrate --seed
```

## Run Tests

Developing...

## Contributing

@author: Jonatam de Sousa Rocha (jonatamsr@gmail.com)
