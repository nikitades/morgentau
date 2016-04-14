# Morgentau CMS

Morgentau is a simple CMS written in PHP and based on Laravel 5.2 for the moment.

## Official Documentation

...is still going to appear somewhere ahead. Stay tuned.

## Installation

Okay.
1. Pull this repo to folder
2. Cd to folder
3. `composer update` the folder
4. `npm install` the folder
5. Set up the empty DB, fill the credentials in `.env` file (form dotenv.example I provided)
6. `php artisan migrate` at the project folder to create the necessary tables
7. Create admin user via /register
8. Set `is_admin` = 1 at this newly created user in your SQL database
9. Login to admin panel via /admin
10. Create the base view (view filename is filled in Laravel-like style, e.g. pages.partials.something instead of something.blade.php)
11. Create the home page by creating the page with `/` url and this test view attached.

Done.

## License

As well as the Laravel framework, the Morgentau CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
