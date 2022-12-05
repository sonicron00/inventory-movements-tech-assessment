# Inventory Movements Application
## Tech Assessment by Ryan Smith
<br>


#### Context:
This application has been developed for a technical assessment. This is a Laravel application utilising the Vue.js framework to present a user interface concerned with products (inventory), their available quantities, and handling the application thereof.
<br><br>
#### Architecture:
This application has been dockerised into component containers (Application, Web and Database) primarily for ease of local deployment, but also to illustrate best practice and pipeline readiness (e.g. Kubernetes).
<br><br>
#### Getting Started:

* Clone the repository
* Execute composer commands for initial build of the containers:<br>
    `docker-compose up -d --build`
* Install composer requirements into the application container:<br>
    `docker-compose exec inventory-movements-app composer install`
* Duplicate the .env.example file to create a local '.env'
* Run the Laravel command to generate the web application key:<br>
    `docker-compose exec inventory-movements-app php artisan key:generate`

@TODO: migration and seeder notes

