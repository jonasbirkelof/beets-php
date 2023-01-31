<img src=".github/assets/images/beetsphp_col_100x421.png#gh-light-mode-only" style="height: 80px;">
<img src=".github/assets/images/beetsphp_col_inv_100x421.png#gh-dark-mode-only" style="height: 80px;">

Beets PHP is a starter template for semi-advanced PHP projects containing an MVC filesystem, routing, autoloader, .env functionality, SCSS compiler, Browser-sync and more. It makes use of other great libraries for the core functionality so make sure you check them out, say thanks and cunsult their documentation!

- [Bramus Router](https://github.com/bramus/router)
- [vlucas PHP dotenv](https://github.com/vlucas/phpdotenv)
- [BrowserSync](https://browsersync.io/docs)

# Table of Contents

- [Installation](#installation)
- [Use with frameworks](#use-with-frameworks)
	- [Tailwind CSS](#tailwind-css)
	- [Bootstrap](#bootstrap)
	- [Beets CSS](#beets-css)
- [Database](#database)
- [File Structure](#file-structure)
	- [Root](#root)
	- [/app](#app)
	- [/config](#config)
	- [/public](#public)
	- [/resources](#resources)
	- [/routes](#routes)

# Installation

Clone this repo to your localhost: 

```bash
git clone https://github.com/jonasbirkelof/beets-php.git
```

1. Open `webpack.mix.js` and change the browserSync proxy to either your local vhost (i.e. *myapp.local*) or your localhost location (i.e. *localhost/myapp*).
2. Install the dependencies from package.json.
	```bash
	npm install
	```
3. Install the dependencies from composer.json.
	```bash
	composer install
	```
4. Rename `.gitignore.example` to `.gitignore`.
5. Rename `.env.example` to `.env` and update the following variables:
	- `APP_NAME`: The name of the app.
	- `APP_URL`: The URL of the app.
	- `APP_COPYRIGHT`: the copyright holder (you or your organization).
	- `DB_*`: your database credentials.
6. Import the file `myapp.sql` to your sql server to create the test database that is used for the included examples.
7. Make an initial compile of your SCSS and JS into the `~/public/assets/` folder.
	```bash
	npm run build
	```
8. Start the local dev server using Browser-sync. A new browser window or tab will open with the local server running.
	```bash
	npm run watch
	```

**Remember to update `webpack.mix.js` if you are adding file types or directories outside of `~/resources/`.**

# Use with frameworks

Beets PHP can be used with any basic basic front-end language like HTML, CSS or JS and comes prepared with a simple example site to demonstrate the functionality of the router and the other functions. 

The folder `~/examples/` contains two folders with files that can be used to quickly get you started with either [Tailwind CSS](https://tailwindcss.com) or [Bootstrap](https://getbootstrap.com) if you would like to use any of them. They also comes with the same simple example site styled using the corresponing framework.

## Tailwind CSS

[Tailwind CSS Documentation](https://tailwindcss.com/docs/installation)

1. Download Taliwind CSS via npm:
    ```bash
    npm i tailwindcss@^3.2.0
	```
2. Move the file `tailwind.config.js` from the examples folder to the project root.
3. Open `~/webpack.mix.js` and add the following to `mix`.
	```js
	.options({
		postCss: [require('tailwindcss')],
	})
	```
4. Replace the main SCSS file `~/resources/scss/app.scss` with `app.scss` from the examples folder.
5. Replace the folders `~/public/partials/` and `~/public/views/` with the same folders from the examples folder.
6. Compile your SCSS using `npm run watch` or `npm run build`.

**Remember to update `tailwind.config.js` and `webpack.mix.js` if you are adding file types or directories outside of `~/resources/`.**

## Bootstrap

[Bootstrap Documentation](https://getbootstrap.com/docs/5.3/getting-started/introduction/)

You can use Bootstrap's SCSS source files and compile them into your own CSS file. That way you can pick what parts of Bootstrap you want to use, for instance only the grid system, modals or buttons! The file `~/examples/bootstrap/_bootstrap.scss` contains every part of Bootstrap and it's recommended that you to import every "step" except for step 6 where you pick the parts you want to use. Refer to the [Bootstrap documentation on importing (option B)](https://getbootstrap.com/docs/5.2/customize/sass/#importing) for details.

1. Download Bootstrap via npm:
	```bash
	npm i bootstrap@^5.2.0
	```
2. Open `webpack.mix.js` and add the following to `mix`.
	```js
	.js('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'js')
	```
	This will compile and add the whole bundled Bootstrap JS file to your `~/public/assets/js/` folder.
3. Add the path to the compiled JS file to the `<head>` tag in `~/public/partials/page-head.php`:
	```html
	<script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.js"></script>
	```
4. Copy the file `_bootstrap.scss` from the examples folder to `~/resources/scss/`.
5. Replace the main SCSS file `~/resources/scss/app.scss` with `app.scss` from the examples folder.
6. Replace the folders `~/public/partials/` and `~/public/views/` with the same folders from the examples folder.
7. Compile your SCSS using `npm run watch` or `npm run build`.

## Beets CSS

[Beets CSS Documentation](https://jonasbirkelof.github.io/beets-css)

If you are using Bootstrap you might want to use the [Beets CSS](https://github.com/jonasbirkelof/beets-css) addon-library for Bootstrap! You can use either the pre-compiled CSS file or the source SCSS files with your project.

### Pre-compiled CSS

1. Download the compiled CSS file from the [GitHub page](https://github.com/jonasbirkelof/beets-css/releases).
2. Place `beets.css` in `~/public/assets/css/`.
3. Add the path to the CSS file to the `<head>` tag in `~/public/partials/page-head.php`:
	```html
	<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/beets.css">
	```

### SCSS source files

1. Create a folder named `beets-css` inside `~/resources/scss/`.
2. Download the source code (.zip) from the [GitHub page](https://github.com/jonasbirkelof/beets-css/releases).
3. Unzip the file and move the contents of `beets-css-master/src/scss/` to the folder you created in step 1: `~/resources/scss/beets-css/`.
4. Open the file `~/resources/scss/beets-css/beets.scss` and check/update the paths to the Bootstrap SCSS source files. Beets CSS uses Bootstrap as a dependency so some of its files are used when compiling.
5. Open the main SCSS file `~/resources/scss/app.css` and import Beets CSS below Bootstrap:
	```scss
	@import 'bootstrap';
	@import 'beets-css/beets';
	```
6. Compile your SCSS using `npm run watch` or `npm run build`.

# Database

The database class is located in the `~/app/database/` folder. Set the database credentials in the `~/.env` file. The database class will use these credentials to establish the PDO connection.

The `PDO::ATTR_DEFAULT_FETCH_MODE` is set to `PDO::FETCH_ASSOC` so that methods `fetch()` and `fetchAll()` will return a associative array by default. If you want to use something else you can override it with attributes in the methods: `fetchAll(PDO::FETCH_BOTH);`.

This is a simple example for making a query:

```php
// Create a new instance of the database class
$db = new Database();

// Fetch all users
$sql = "SELECT * FROM users"; // Create a SQL query
$usersList = $db->query($sql)->fetchAll(); // Fetch the results
return $usersList; // Return the results

// Fetch a single post
$query = "SELECT * FROM users WHERE id = ?"; // Create a SQL query
$user = $db->query($query, [$id])->fetch(); // Fetch the results
return $user; // Return the results
```

# File Structure

This is the core file structure of the framework. Other folders like `.git/` and `examples/` are not essential and are not presented here.

```
ROOT/
│
├── app/
│   ├── controllers/
│   ├── database/
|   |   └── Database.php
|   ├── helpers/
|   |   ├── functions.php
|   |   └── view.php
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
|   ├── partials/
|   ├── storage/
|   ├── views/
|   └── index.php
│
├── resources/
|   ├── js/
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
└── webpack.mix.js.example
```

### Root

**.env** - Here goes all important credentials and information that will be used by the system. **This file must not be made public!**<br>
**.env.example** - A template for `.env`. This file should only contain placeholder data.<br>
**.gitignore** - Setup your gitignore to exclude files and folders that you don't want to push to the repo, like the `.env` file).<br>
**.gitignore.example** - A template for `.gitignore`.<br>
**.htaccess** - This file points the visitors to the `~/public/` folder.<br>
**composer.json** - This file contains the Composer dependencies and the autoloader configuration.<br>
**myapp.sql** - This contains the query for creating the sample database used in the example files.<br>
**package.json** - This file contains the npm dependencies.<br>
**README.md** - Read Me, please! :)<br>
**webpack.mix.js** - This file contains Browser-sync configuration and SCSS compiler settings.<br>
**webpack.mix.js.example** - A template for `webpack.mix.js`.<br>

### /app
Here goes the app-wide logic files. All connection to the database should be in these files so that they will not be accessible for the users.

**/controllers**<br>
Store your controller files here. The naming convention is "UserController.php".

**/database**<br>
Store your database files here.

- **Database.php** - Contains the database class that handles the PDO connection and query requests.

**/helpers**<br>
Store your helper files here, for example custom functions and classes.

- **functions.php** - Contains app-wide relevant functions like the `dd()` (die-and-dump) function.
- **view.php** - Contains the view function that is used to render a view.

**/models**<br>
Store your model files here. The naming convention is "User.php".

- **App.php** - Contains methods that are used app-wide, for instance a function to toggle the active navigation option.

### /config
Store your config files here.

- **app.php** - App-wide variables, constants etc.<br>
- **data.php** - App-wide arrays and lists.<br>
- **dotenv.php** - Configuration for the dotenv library.<br>

### /public
This is the public file that the users can access. The main `index.php` file lives here. Make sure not to store any secret information in this folder.

**/assets**<br>
Here are all the compiled CSS and JS files, as well as images that the app uses.

**/storage**<br>
Store files that are uploaded via the app here, for instence profile pictures and files.

**/views**<br>
Here are all the views. Make your own files to create a local structure. There should not be any connections to the database etc in here. Use the models for calculations and data collections before loading a view.

### /resources
In this folder are uncompiled code, like SCSS.

### /routes
Store your route files here.

- **web.php** - Here are all the routes that the app uses.

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