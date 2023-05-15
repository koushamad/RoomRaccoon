# RoomRaccoon
I developed this project with TDD methodology. but i didn't have enough time to develop front-end part.

After finishing time, i stopped the development and between my another meetings i did some small hot fixes.
#### list of hot fixes:
- Fix database name in the database connection.
- Refactor the tests.
- Commit the README.md file.

#### Project details
- Restful API Design
- SOLID principles compatible. "but I used dependency injection"
- Database class use the singleton design pattern.

## Requirements
- PHP 8.1
- Composer v2
- MySQL

## Installation
Clone the repository and run the following commands:
```shell
git clone https://github.com/koushamad/RoomRaccoon.git
cd RoomRaccoon

# Create a database named room_raccoon and shopping_list table
mysql -u root -p < database/create_room_raccoon_database.sql
mysql -u root -p -e room_raccoon < database/migrations/create_shopping_list_table.sql

# install dependencies
composer install

# run the server
php -S localhost:8080 -t public
```

## Tests
- you have to run server first and then run the tests

Open a new terminal tab and go to the project directory and run the following command:
```shell
# run the tests
vendor/bin/phpunit
``` 