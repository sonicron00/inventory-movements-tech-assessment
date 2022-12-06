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
* Run the initial database migrations:<br>
    `docker-compose exec inventory-movements-app php artisan migrate`<br>
* Run the database seeders:
    `docker-compose exec inventory-movements-app php artisan db:seed`<br><br>
  Note: The seeders work together to create a product and then subsequently link all transactions to that product.



#### Assumptions, Scope and Design Considerations:
* Authentication/user profiles excluded from scope
* Within the 'Products' database table - design decision made not to store a 'quantity' field - although anticipated volumes are not known, the current specification requires 'on the fly' computation of value so a hard coded quantity would be redundant in this application. Arguably could have been added for future proofing, but in this case a simple migration and seeder would address this should scope change in the future.
* Applications and Purchases have been created as individual database tables (though they are almost identical) for scalability and separation of concern. Model inheritance is applied to keep the code clean.