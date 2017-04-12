# Unicloud Server

> A Laravel REST API for Unicloud

## Server Requirezments  
  
* PHP >= 5.6.4
* MySQL
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Composer
* Laravel

## Build Setup

``` bash
# install dependencies
npm install
composer install

# copy and edit your .env 
cp .env.example .env
nano .env

# create a database to match your .env file

# migrate the databases
php artisan migrate 

# serve at localhost:8000
php artisan serve

