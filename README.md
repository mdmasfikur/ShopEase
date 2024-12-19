# Laravel eCommerce Website

This is a Laravel-based eCommerce website designed to offer a seamless shopping experience. It includes features like user authentication, product catalog, shopping cart, and checkout functionality.

## Prerequisites

Before running the application, ensure you have the following installed:

- [PHP 8.1 or higher](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [MySQL or MariaDB](https://www.mysql.com/)
- [Node.js](https://nodejs.org/)
- [npm](https://www.npmjs.com/)

## Installation

Follow the steps below to set up the project on your local machine.

### 1. Clone the repository

```shell
git clone 'https://github.com/mdmasfikur/ShopEase.git/'
cd ShopEase
```
### 2. Install Packages via Composer
```shell
composer install
```

### 3. Migrate Database
```shell
php artisan migrate
```
### 4. Test Data
```shell
php artisan db:seed
```
will seed the database with a default admin user 

Email:
```
admin@example.com
```
Password:
```
123456789
```
It will also create some fake Categories and Products.

### 5. Start Server
After Generating Fake Data 
Run:
```shell
php artisan serve
```
This will run the server in `localhost:8000`

