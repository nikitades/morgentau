# Morgentau CMS

Morgentau is a Laravel-based small and simple CMS. It was designed to satisfy my own requests once upon a time. It has been a little bit modified since then, and a pretty bunch of sites are already controlled by it. 

I tried to preserve the global rules and features of Laravel building this CMS. Anyway feel free to modify and change it since it is under the WTFPL licence aggreement. The more is better in this case.

## Official Documentation

Sorry, there are no any official documentation. However there is a small installation guide.

##Installation

1. Git clone this repo anywhere you want the ServerRoot (or whatever it is via Nginx) is.
2. Cd to this folder and `composer update` in it. The composer will gladly download everything you may need.
3. Now its time to `npm install` all the needed nodejs features. The CMS uses Gulp and Sass in general, and also Elixir as a helper. These tools pull much of the dependancies, so the installation in general isn't fast. Go play any timekiller for 5 minutes.
4. Create the project DB in any acceptable way. Remember the username and password. And also server IP. And keep in mind that the DB user should have enought rights to modify this DB.
5. Copy .env.example to .env. Then fill the .env file with all the data that is empty.
6. In case if you are already not in the folder, `cd` to the project again and `php artisan key:generate`. This will make a unique key in your .env file. The security requirement.
7. `php artisan migrate` the DB. This will make the basic tables structure for all the supplied modules.
8. Go to `/register` and register. After the successful registration you will be redirected to the empty main page, its ok. Then go to your DB and change the `admin` binary flag in the one and only entry in the `users` table from 0 to 1.
9. You are now the admin. Log in in the admin panel (`/admin`) and go to the Views section. Create the base view (this is not the actual view file, just an alias for the page what view shout it use). Use for example `regularPage.blade.php` name. There is already a view with such a name, so it's ready to be assigned to the page.
10. Go to the `/admin/pages` and create the first page. Edit it and assign the previously created view. Since the created page is the root page, it's URL is limited to `/`. So write something to the page content, save it and go to the `/`. Look and check if the text is show. **Everything done**.
11. *Optional* - set your locale in app.php.