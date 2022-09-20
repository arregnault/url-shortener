# URL Shortener
> URL shortener developed with Laravel framework.

## Table of Contents
* [General Info](#general-information)
* [Technologies Used](#technologies-used)
* [Features](#features)
* [Setup](#setup)
* [Usage](#usage)
* [Project Status](#project-status)
* [Room for Improvement](#room-for-improvement)


## General Information
This project provides an API to generate short URLs and redirect them to the original links.

It was developed as a practice.


## Technologies Used
- [Swagger Documentation](https://github.com/DarkaOnLine/L5-Swagger)
- [Laravel Framework 8](https://laravel.com/docs/8.x)
- [MySQL](https://dev.mysql.com/doc/mysql-getting-started/en/)


## Features
- Generate shortened URLs for quick use.


## Setup
Clone the project:
```
git clone https://github.com/arregnault/url-shortener.git
```

Install Laravel dependencies:
```
cd url-shortener
composer install
```

Generate key:
```
php artisan key:generate
```

Run migrations:
```
php artisan migrate --seed
```

Create testing database:
```
touch database/testing.sqlite
```


## Usage
Run tests:
```
php artisan migrate --env=testing && ./vendor/bin/phpunit --testsuite Unit
```

Run tests coverage:
```
php artisan migrate --env=testing && ./vendor/bin/phpunit --testsuite Unit --coverage-html coverage/
```

Web access to documentation
```
http://127.0.0.1:8000/api/documentation
```


## Project Status
Project is: _in progress_.


## Room for Improvement
TODOs for future development.

To do:
- Visitors log.
- User authentication.
- Management of links owned by users.

