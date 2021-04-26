<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# Laravel API - R3-D3

System built in Laravel to show my skills

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.8/installation#installation)

# Getting started

Clone the repository

    git clone https://github.com/fittipaldi/r3-d3.git

Switch to the repo folder

    cd r3-d3 - this is the Project Root

# Installation

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file (**PS.: Check the database credentials**) 

    cp .env.example .env 
    
    Please create a Database and set up the credential in this variables
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
 
Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    
Run the database seed

    php artisan db:seed

Start the local development server

    php artisan serve --port=8000

You can now access the server at http://localhost:8000

#### Run Test
    
    ./vendor/bin/phpunit

# API

### API Authorization

    Header
        Authorization: Bearer JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0
        
        Authorization: Bearer NO-JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0

API Actions
-------

##### POST /api/v1/spacecraft/add - Add spacecraft params: [name, class, crew, image, value, status, note, armament[][title, qtd]]
 
    curl --location --request POST 'http://localhost:8000/api/v1/spacecraft/add' \
    --header 'Authorization: Bearer JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0' \
    --form 'name="Devastator"' \
    --form 'class="Star Destroyer"' \
    --form 'crew="35000"' \
    --form 'image="https:\\\\url.to.image"' \
    --form 'value="1999.99"' \
    --form 'status="operational"' \
    --form 'armament[1][title]="Turbo Laser"' \
    --form 'armament[1][qtd]="10"' \
    --form 'armament[2][title]="Ion Cannons"' \
    --form 'armament[2][qtd]="20"'
    
##### GET /api/v1/spacecrafts -  List of spacecrafts params: pagination [?page=1]

    curl --location --request GET 'http://localhost:8000/api/v1/spacecrafts?page=1' \
    --header 'Authorization: Bearer JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0' \

##### GET /api/v1/spacecraft/id/{id} - Spacecraft by ID
    
    curl --location --request GET 'http://localhost:8000/api/v1/spacecraft/id/1' \
    --header 'Authorization: Bearer JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0' \

##### PUT /api/v1/spacecraft/edit/{id} - Edit spacecraft params: [name, class, crew, image, value, status, note, armament[][title, qtd]]

    curl --location --request PUT 'http://localhost:8000/api/v1/spacecraft/edit/1' \
    --header 'Authorization: Bearer JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0' \
    --header 'Content-Type: application/x-www-form-urlencoded' \
    --data-urlencode 'name=Devastator edited' \
    --data-urlencode 'class=Star Destroyer' \
    --data-urlencode 'crew=35000' \
    --data-urlencode 'image=https:\\url.to.image' \
    --data-urlencode 'value=1999.99' \
    --data-urlencode 'status=damaged' \
    --data-urlencode 'armament[1][title]=Turbo Laser' \
    --data-urlencode 'armament[1][qtd]=11' \
    --data-urlencode 'armament[2][title]=Ion Cannons' \
    --data-urlencode 'armament[2][qtd]=22'

##### DELETE /api/v1/spacecraft/delete/{id} - Delete Order by ID

    curl --location --request DELETE 'http://localhost:8000/api/v1/spacecraft/delete/1' \
    --header 'Authorization: Bearer JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0'
    