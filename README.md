<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

### Practical job test Back End Developer.

Company: Search and Stay

----------

# Start

# Used technologies

Laravel 9, PHP 8.1, Mysql 5.7

## Instalation

Clone the repository and together its submodules (Laradock)

    git clone https://github.com/kelver/search-and-stay-challenge.git --recurse-submodules

where we use LaraDock to build the application environment.

Enter the laradock folder, located at the root of the project, and make a copy of .env.example to configure the environment.

Afterwards, run the necessary containers

    docker-compose up -d nginx mysql

Then run the command

    docker-compose exec workspace bash

Access the project folder according to the settings made through laradock's .env file

    cd /var/www/

Install all dependencies with composer

    composer install

Configure the project's .env file, according to the laradock settings
    
    Database, ports...
    
Perform application migrations

    php artisan migrate

Run the command to generate the JWT secret key

    php artisan jwt:secret

If everything is ok, you should see the screen when accessing the application url:

![Screen 01](https://user-images.githubusercontent.com/22528943/213066507-fdf30990-0b99-4e5a-a4d3-f1eccecbe32d.png)


Documentation performed by Postman: [Documentation](https://documenter.getpostman.com/view/2474854/2s8ZDVZPBQ)

More information and details, I am available.

----------
