# Inventory Movements Application
## Tech Assessment by Ryan Smith
<br>


#### Context:
This application has been developed for a technical assessment. This is a Laravel application utilising the Vue.js framework to present a user interface concerned with products (inventory), their available quantities, and handling the application thereof.
<br><br>
#### Architecture:
This application has been dockerised into component containers (Application, Web and Database) primarily for ease of local deployment, but also to illustrate best practice and pipeline readiness (e.g. Kubernetes).
<br><br>

#### Functionality / Solving the problem:
The basic assessment criteria functionality is addressed within the 'Product Application' section:
* A list of inventory items, descriptions, and computed quantity on hand is presented.
* A numeric input is available, and a 'calculate' button which calculates the monetary value of the quantity input, based on purchase transactions oldest to newest (first in-first out).
* If the input quantity is below zero, or greater than the quantity available, a warning is presented.
* Otherwise, the calculated value is presented.
<br><br>
  
#### Extra Credit: Process application of requested quantity:
* After calculating the monetary value, the user has the option to 'Apply' the inventory quantity. This creates an 'application' transaction, reducing the quantity on hand. Once applied the table is updated and the user sees the updated quantity.
<br><br>

#### Extra Credit: Product administration:
* Although the seeder takes care of the minimum data required to demonstrate the application, it is possible to add or edit inventory items via the 'Product admin' section.
* Navigating to this section presents a list of all items, where the user can edit the description or add new items accordingly.
<br><br>

#### Extra Credit: Transactions:
* As above, the seeder takes care of the minimum data required to demonstrate the application, and the provided 'application' and 'purchase' transactions are loaded upon seeding.
* Navigating to the 'Transactions' section presents a list of all transactions.
* It is possible to input 'purchase' transactions, which subsequently increase the available quantity on hand of the product purchased.
* Note that 'application' transactions from the 'Product Application' area also appear within this transaction listing.
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
* Unit tests can be executed:<br>
  `docker-compose exec inventory-movements-app vendor/bin/phpunit`
* Run the initial database migrations:<br>
    `docker-compose exec inventory-movements-app php artisan migrate`<br>
* Run the database seeders:
    `docker-compose exec inventory-movements-app php artisan db:seed`<br><br>
  Note: The seeders work together to create a product and then subsequently link all transactions to that product.
* Install package dependencies:<br>
  `npm install`
* Serve the web application:<br>
    `npm run dev`
  
---
* Application should be running at http://localhost:8080/
* Local MySQL database should be available to connect at port 33065 using:<br> user: laravel<br> password: supersecret<br> database: app 
---
#### Assumptions, Scope and Design Considerations:
* Authentication/user profiles excluded from scope
* Within the 'Products' database table - design decision made not to store a 'quantity' field - although anticipated volumes are not known, the current specification requires 'on the fly' computation of value so a hard coded quantity would be redundant in this application. Arguably could have been added for future proofing, but in this case a simple migration and seeder would address this should scope change in the future.
* Applications and Purchases have been created as individual database tables (though they are almost identical) for scalability and separation of concern. Model inheritance is applied to keep the code clean.

New in July 2023...