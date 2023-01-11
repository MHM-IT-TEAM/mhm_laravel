<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



# Getting started
The web application is a laravel application containing php and java script parts.
It runs with the apache webserver and mysql database, together in xampp.

This guide will lead you through the setup and installation.


## Which Software I need to install?

We installed following versions. 

|software|version|
|---------|--------|
|xampp|3.3.0|
|php|**7.4.3** or **7.4.7**|
|composer|2.5.1|
|laravel|8.27.0|
|node js|18.12.1|
|npm|8.19.2|

### 1. Install Xampp
### 2. Checkout mhm-laravel projects

And save *xampp/htdocs/mhm_laravel* folder. 

### 3. Check php version in Xamp installation `php -v` and change if necessary

If version is higher than 8.x.x than you need to manually downgrade to php 7.4.3 or 7.4.7	
I recommend this instruction. It worked for me:
[https://php101.net/tutorial/change-xampp-php-version-on-windows/#Okay_so_what_to_download](https://php101.net/tutorial/change-xampp-php-version-on-windows/#Okay_so_what_to_download)

(I have the php windows installer from here, same as in above tutorial: [https://www.php.net/releases/](https://www.php.net/releases/)    7.4.3, threadsaf, zip or .exe (important!)
And copy *xampp/php/php.ini-development* and rename it to *xampp/php/php.ini*

### 4. Install Composer
Download composer [https://getcomposer.org/download/](https://getcomposer.org/download/)
And install.

### 5. Install Laravel

open gitbash in *xampp/htdocs/mhm_laravel* project:

`composer install`
(if errors then make sure php.ini has enabled the required extensions. Remove the `;` at the beginning of the line.)

`php artisan migrate`          (this migrate the project as laravel project and installs all dependencies in mhm_laravel/vendor folder)

`php artisan serve`            (this starts the laravel app. this is mandatory to see it in browser. )

## Run application
1. Open Xampp control panel
2. Start apache (webserver) 
3. Start mysql (database)
4. Open cmd at *xampp/htdocs/mhm_laravel* and run: `php artisan serve`

You should be able to access:
- localhost:8000/phpMyAdmin
- localhost:8000/login or localhost:8000/register


## How to setup Database?
### 1. Import databases
Open localhost:8000/phpMyAdmin
Create two databases: *mhm_patient_system* and *mhm_inventory_system*
Go to hospital server phpMyAdmin: Export the databases *mhm_patient_system* and *mhm_inventory_system* from the hospital server, containing structure and data.
Open localhost:8000/phpMyAdmin: Import both databases

If error: File to big to upload.
Then adapt fileupload accordingly:
1. Open file: *xampp/php/php.ini*
2. Modify two lines:
```
post_max_size=40M
upload_max_filesize=40M
```

After import, better check structure of table. 
All ID-columns of all tables must set to "Auto Increment".

### 2. Set MySQL root password everywhere the same
There are 3 locations:
- MySQL server: 
    Open Xampp Shell in Xamp Control Panel (right side button).
    Type: `mysqladmin -u root password`
    Enter password
- Set password in phpmyadmin: *xampp/phpMyAdmin/config.ini.php*
- Set password in project: *xampp/htdocs/mhm-laravel/.env*
    

## How to install Node JS for home- website
If you can not redirect from /home tab to joycenter or any other page, JS is not working.
Because parts of the application are in Java Script we need to install JS runtime: Node JS.

1. Download Node JS
2. Install Node JS, make sure npm is selected as well during installation
3. Check installation in cmd: `npm -v`
4. Go to *xampp/htdocs/mhm-laravel* and open cmd and type:
```
npm install laravel-mix@latest --save-development
npm update vue-loader

npm run dev
```
5. Home-website should be able to redirect to joycenter/admission, and other pages as well.

## Finish, application should run now!!



# Development

# How to add a column to an existing database table without deleting data?
1. Create a new migration table with: `php artisan make:migration add_$COLUMN_to_$TABLE`
2. Edit this file. Add column to up-function, eg: $table->boolean('column_name')->default(0);
3. Run: `composer dumpauto`
4. Run: `php artisan migrate` or with a specific file: `php artisan migrate --path="./database/migrations/$FILENAME.php" `
5. Finish, check in database table if column was created.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
