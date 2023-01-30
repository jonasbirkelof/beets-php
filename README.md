<img src="assets/images/beetsphp_col_100x421.png" style="height: 80px;">

Beets PHP is a starter template for advanced PHP projects containing an MVC filesystem, routing, autoloader, .env functionality, Scss compiler, Tailwind CSS, Browser-sync and more. 

Please refer to the documentations for detailed instructions if you want to setup things differently:

- [TailwindCSS](https://tailwindcss.com/docs/installation)
- [BrowserSync](https://browsersync.io/docs)
- [Bramus Router](https://github.com/bramus/router)
- [PHP dotenv](https://github.com/vlucas/phpdotenv)

## Contents

- [Clone and Download](#Clone-and-download)
- [Setup](#setup)
- [Use with Bootstrap](#use-with-bootstrap)
- [Use with Beets CSS](#use-with-beets-css)
- [Database](#database)
- [File Structure](#file-structure)

## Clone and Download

Clone this repo to your localhost using: 
```bash
git clone https://github.com/jonasbirkelof/beets-php.git
```
...and follow the setup instructions below, or just download the zip-file.

## Setup

1. Open *webpack.mix.js* and change the browserSync proxy to either your local vhost (i.e. *myapp.local*) or your localhost location (i.e. *localhost/myapp*).
2. Rename *.env.example* to *.env*.
3. Open *.env* and update the following variables:
	- Change `APP_NAME="My App"` to the app name.
	- Change `APP_URL=http://myapp.local` to either your local vhost (i.e. *myapp.local*) or your localhost location (i.e. *localhost/myapp*).
	- Change `APP_COPYRIGHT="The Owner"` to the copyright holder (you or your organization).
	- Change `DB_*` to your database credentials.
4. Rename *.gitignore.example* to *.gitignore*.
5. Run `npm install` to download and install all npm dependencies from package.json.
6. Run `composer install` to download and install all composer dependencies from composer.json.
7. Import the file `myapp.sql` to your sql server to create the test database that is used for the included examples.
8. Run `npm run build` to make an initial compile of Tailwind CSS, SCSS and JS into the *~/public/assets* folder.
9. Run `npm run watch` to (compile again and) start Browser-ssync. A new browser window or tab will open with the local server running on port 3000 (or higher if you have multiple instances of Browser-sync running).

**Remember to update *tailwind.config.js* and *webpack.mix.js* if you are adding file types or directories outside of *~/resources/*.**

## Use with libraries

Beets PHP comes prepared for use with [Tailwind CSS](https://tailwindcss.com) and [Bootstrap](https://getbootstrap.com). In the folder **~/examples** are two folders named **bootstrap** and **tailwindcss** containing files that will help you get started as well as an example site with some basic styling.

Follow the installation instructions below to get started with your preferred library.

### Tailwind CSS

1. Download Taliwind CSS via npm:
    ```bash
    npm i tailwindcss@^3.2.0
	```
2. Move the file **~/examples/tailwindcss/tailwind.config.js** to the project root (same place as, for instance **webpack.mix.js**).
3. Open **~/webpack.mix.js** and add the following to `mix`.
	```js
	.options({
		postCss: [require('tailwindcss')],
	})
	```
4. Replace the main scss file **~/resources/scss/app.scss** with the **~/examples/tailwindcss/app.scss**.
5. Replace the folders **partials** and **views** in the  **~/public** folder with the ones in **~/examples/tailwindcss/**.
6. Compile your scss using `npm run watch` or `npm run build`.

### Bootstrap

It's recommended that you use the .scss source files and compile them along with you custom scss. That way you can pick what parts of Bootstrap you want to use, for instance the grid system, modal or buttons.

1. Download Bootstrap via npm:
	```bash
	npm i bootstrap@5.2.0
	```
2. Open *webpack.mix.js* and add the following to `mix`. This will compile/add the whole Bootstrap bundle .js-file to your assets folder.
	```js
	.js('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'js')
	```
3. Add the compiled .js-file in **~/public/assets/js/** to your `<head>` in **~/public/partials/page-head.php**:
	```html
	<script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.js"></script>
	```
4. Copy the file **~/examples/bootstrap/_bootstrap.scss** to **~/resources/scss/**.
	**Optional:** Customize the content of Bootstrap in **_bootstrap.scss**. The file contains every part of Bootstrap and it's recommended that you to import every "step" except for step 6 where you pick the parts you want to use. Refer to the [Bootstraop documentation (option B)](https://getbootstrap.com/docs/5.2/customize/sass/#importing) for details.
5. Replace the main scss file **~/resources/scss/app.scss** with the file **~/examples/bootstrap/app.scss**	
6. Replace the folders **partials** and **views** in the  **~/public** folder with the ones in **~/examples/bootstrap/**.
7. Compile your scss using `npm run watch` or `npm run build`.

### Beets CSS

If you have installed Bootstrap you might want to use our own addon-library for Bootstrap called Beets CSS.

- [Beets CSS on GitHub](https://github.com/jonasbirkelof/beets-css)
- [Beets CSS Documentation](https://jonasbirkelof.github.io/beets-css)

You can use either the pre-compiled files or the sass files in your project. Follow the instructions below for the preferred method.

#### Pre-compiled files

1. Download the compiled .css file from the [GitHub page](https://github.com/jonasbirkelof/beets-css/releases).
2. Place `beets.css` in `~/public/assets/css/`.
3. Include the .css file inside `<head>` in `~/public/partials/page-head.php`:
	```html
	<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/beets.css">
	```

#### Source files

1. Create a folder named **beets-css** in **~/resources/scss/**.
2. Download the Beets CSS source code from the [GitHub page](https://github.com/jonasbirkelof/beets-css/archive/refs/heads/master.zip).
3. Unzip the folder, copy the content inside **beets-css-master/src/scss/** and paste it into the folder you created in step 1; **~/resources/scss/beets-css/**.
4. Open the file **~/resources/scss/beets-css/beets.scss** and check/update the paths to the Bootstrap references. Beets CSS uses Bootstrap as a dependency so some of its files are used when compiling. The correct path could look something like this: `@import "../../../node_modules/bootstrap/scss/functions";`.
5. Open the file **~/resources/scss/app.css** and include Beets CSS below Bootstrap:
	```scss
	@import 'bootstrap';
	@import 'beets-css/beets';
	```
6. Now you should be able to compile app.scss as usual with `npm run watch` or `npm run build`.

## Database

The database class is located in the `~/app/database/` folder.
Set the database credentials in `./.env`. The database class will use them to create the PDO connection

The `PDO::ATTR_DEFAULT_FETCH_MODE` is set to `PDO::FETCH_ASSOC` so that `->fetch()` and `->fetchAll()` will use `PDO::FETCH_ASSOC` by default. If you want to use semthing else you can override it within the `()`.

Below is an example for making a query:

```php
// Create a new instance of the database class
$db = new Database();

// Fetch all users
// Create a query
$query = "SELECT * FROM users";
// Fetch result
$usersList = $db->query($query)->fetchAll();
// Return result
return $usersList;

// Fetch a single post
// Create a query
$query = "SELECT * FROM users WHERE id = ?";
// Fetch result
$user = $db->query($query, [$id])->fetch();
// Return result
return $user;
```

## File Structure

```
ROOT/
|
├── app/
|   ├── controllers/
|   ├── database/
|   |   └── Database.php
|   |
|   ├── exceptions/
|   ├── helpers/
|   |   ├── functions.php
|   |   └── view.php
|   |
|   └── models/
|       └── App.php
|
├── config/
|   ├── app.php
|   ├── data.php
|   └── dotenv.php
|
├── public/
|   ├── assets/
|   |   ├── css/
|   |   ├── images/
|   |   └── js/
|   |
|   ├── storage/
|   ├── views/
|   └── index.php
|
├── resources/
|   ├── js/
|   ├── libs/
|   └── scss/
|
├── routes/
|   └── web.php
|
├── .env.example
├── .gitignore.example
├── .htaccess
├── composer.json
├── myapp.sql
├── package.json
├── README.md
├── tailwind.config.js
└── webpack.mix.js
```

### Root

**.env** - Here goes all important credentials and information that will be used by the system. See the [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) library. This file must not be pushed to the repo!<br>
**.env.example** - This file should only contain example/placeholder data that can be pushed to a repo for sharing.<br>
**.gitignore** - Setup your gitignore to exclude files and folders that you don' want to push to the repo (lie the .env file).<br>
**.gitignore.example** - A template for the .gitignore.<br>
**.htaccess** This - file is important to point the visitors to the *~/public* folder.<br>
**composer.json** - This file contains the Composer dependencies needed for the project as well as configurations for the autoloader.<br>
**myapp.sql** - This contains the query for creating the sample database used in the example files.<br>
**package.json** - This file contains the NPM dependencies needed for the project.<br>
**README.md** - Read Me please!<br>
**tailwind.config.js** - This file contains configurations for the Tailwind CSS compiler.<br>
**webpack.mix.js** - This file contains Browser-sync configuration and SCSS compiler settings.<br>

### /app
Here goes the app logic files. All connection to the database should be in these files since because they will not be accessible for the users.

**/controllers**<br>
Store your controller files here. The naming convention is "**UserController.php**".

**/database**<br>
Store your database files here.

- **Database.php** - Contains the database class that handles PDO connection and query requests.

**/exceptions**<br>
Store your exceptions files here.

**/helpers**<br>
Store your helper files here. For example custom functions.

- **functions.php** - Contains app relevant functions like the `dd()` function.
- **view.php** - Contains the view function that the MVC pattern files are using to render a view.

**/models**<br>
Store your model files here. The naming convention is "**User.php**".

- **App.php** - Contains methods that are used for the application generally, for instance to set the active navigation item based on current URI.

### /config
Store your config files here.

- **app.php** - Contains variables, constants etc that the application uses.<br>
- **data.php** - Contains arrays and lists.<br>
- **dotenv.php** - Contains configurations for the dotenv library.<br>

### /public
This is the public file that the users can access. The main **index.php** file lives here.

**/assets**<br>
Here are all the compiled css and js files, as well as images that the application uses and compiled libraries like locally hosted Bootstrap or FontAwesome.

**/storage**<br>
Store uploaded files here, for instence profile pictures and submitted .pdf files.

**/views**<br>
In this folder are all views. Make your own files to create a local structure. There should not be any connections to the database etc in here. Use the models for calculations and data collections before loading a view.

### /resources
In this folder are uncompiled code, like scss.

### /routes
Store your route files here.

**Common Resource Routes:**
| Route | Description |
|---|---|
| index | Show all listings |
| show | Show single listing |
| create | Show form to create new listing |
| store | Store new listing |
| edit | Show form to edit listing |
| update | Update listing |
| destroy | Delete listing |

// webpack.mix.js

let mix = require('laravel-mix');

mix
    .setPublicPath('./public/assets')
    .js('resources/js/app.js', 'js')
    .sass('resources/scss/app.scss', 'css')
    .browserSync({
        proxy: 'beetsphp.local', // Set to your "localhost/folder" or virtual host "myvhost.local"
        files: [
            './**/*.html',
            './**/*.php',
            './resources'
        ]
    });