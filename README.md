E-Commerce API
--------------

Welcome to the E-Commerce API! This API provides endpoints for managing products and variants in an e-commerce system.

Table of Contents:

-   Getting Started: #getting-started

-   Prerequisites: #prerequisites

-   Installation: #installation

-   Running the Tests: #running-the-tests
-   API Endpoints: #api-endpoints
-   Architectural Decisions: #architectural-decisions
-   Assumptions: #assumptions
-   Contributing: #contributing
-   License: #license

Getting Started
---------------

### Prerequisites

-   PHP (>= 7.4)
-   Composer
-   Laravel (>= 9)
-   MySQL or any other compatible database

### Installation

1.  Clone the repository:



```
git clone https://github.com/yourusername/ecommerce-api.git cd ecommerce-api

```





1.  Install dependencies:



```
composer install

```





1.  Configure your database settings:

    -   Copy the `.env.example` file to `.env` and update the settings.
2.  Generate application key:



```
php artisan key:generate

```





1.  Run migrations and seed the database:



```
php artisan migrate --seed

```





Running the Tests
-----------------

To run the PHPUnit tests:



```
php artisan test

```





API Endpoints
-------------

Products:

-   GET /api/products: Retrieve a list of all products.
-   GET /api/products/{id}: Retrieve details of a specific product.
-   POST /api/products: Create a new product.
-   PUT /api/products/{id}: Update an existing product.
-   DELETE /api/products/{id}: Delete a product.
-   GET /api/products/search/{keyword}: Search for products based on a keyword.

Variants:

-   GET /api/products/{productId}/variants: Retrieve variants of a product.
-   POST /api/products/{productId}/variants: Create a new variant for a product.
-   PUT /api/products/{productId}/variants/{variantId}: Update an existing variant.
-   DELETE /api/products/{productId}/variants/{variantId}: Delete a variant.

Architectural Decisions
-----------------------

Technologies Used:

-   Laravel: PHP web application framework.
-   MySQL: Relational database management system.
-   PHPUnit: Testing framework for PHP.

Design Patterns:

-   Repository Pattern: Separation of concerns for database operations.
-   Resourceful Controllers: Using Laravel's conventions for RESTful API controllers.
-   Factory Pattern: Generating model instances for testing.

Assumptions
-----------

-   The API assumes a MySQL database for data storage.


License
-------

This project is licensed under the MIT License - see the LICENSE file for details.