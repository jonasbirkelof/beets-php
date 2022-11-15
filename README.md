# Beets PHP

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
- [File Structure](#file-structure)

## Clone and Download

Clone this repo to your localhost using: 
````
git clone https://github.com/jonasbirkelof/beets-php.git
````
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
7. Run `npm run build` to make an initial compile of Tailwind CSS, SCSS and JS into the *~/public/assets* folder.
8. Run `npm run watch` to (compile again and) start Browser-ssync. A new browser window or tab will open with the local server running on port 3000 (or higher if you have multiple instances of Browser-sync running).

**Remember to update *tailwind.config.js* and *webpack.mix.js* if you are adding file types or directories outside of *~/resources/*.**

## Use with Bootstrap

You can use Beets PHP with [Bootstrap 5](https://getbootstrap.com) and it's recommended that you use the .scss-files and compile them along with you custom/tailwind scss. That way you can pick what parts of Bootstrap you want to use, for instance the grid system, modal or buttons.

Download Bootstrap via npm:

````
npm i bootstrap@5.2.0
````

When the install is done, you need to do some configurations. These steps assume that you want to use the source files (scss) and some js components like modals and popovers.

Open *webpack.mix.js* and add the following to `mix`. This will compile/add the whole Bootstrap bundle .js-file to your assets folder.

````
.js('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'js')
````

Add the .js-file to your `<head>` in *~/public/index.php*. 

Then you need to import the Bootstrap files you want to use to your *app.scss* file. First, create a file called *_bootstrap.scss* in *~/resources/scss/*. Then import it in *app.scss* below the Tailwind CSS imports:

````
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

@import 'bootstrap';
````

In *_bootstrap.scss* you import the parts of Bootstrap that you want to use. Refer to the [documentation (option B)](https://getbootstrap.com/docs/5.2/customize/sass/#importing), but I recommended that you to import everything in the example except for step 6 where you pick your parts. 

Here is an example of *_bootstrap.scss*:

````
// 1. Include functions first (so you can manipulate colors, SVGs, calc, etc)
@import "../../node_modules/bootstrap/scss/functions";

// 2. Include any default variable overrides here

// 3. Include remainder of required Bootstrap stylesheets
@import "../../node_modules/bootstrap/scss/variables";

// 4. Include any default map overrides here

// 5. Include remainder of required parts
@import "../../node_modules/bootstrap/scss/maps";
@import "../../node_modules/bootstrap/scss/mixins";
@import "../../node_modules/bootstrap/scss/root";

// 6. Optionally include any other parts as needed
@import "../../node_modules/bootstrap/scss/utilities";
@import "../../node_modules/bootstrap/scss/grid";
@import "../../node_modules/bootstrap/scss/alert";
@import "../../node_modules/bootstrap/scss/buttons";
@import "../../node_modules/bootstrap/scss/card";
@import "../../node_modules/bootstrap/scss/dropdown";
@import "../../node_modules/bootstrap/scss/forms";
@import "../../node_modules/bootstrap/scss/modal";
@import "../../node_modules/bootstrap/scss/tooltip";

// 7. Optionally include utilities API last to generate classes based on the Sass map in `_utilities.scss`
@import "../../node_modules/bootstrap/scss/utilities/api";

// 8. Add additional custom code here
````

Now when you save or compile via `npm run watch` or `npm run build` you should be able to use Bootstrap with you Beets PHP project.

## Use a database

The database class is located in the `~/app/database/` folder.
Set the database credentials in `./.env`. The database class will use them to create the PDO connection

!!! The Database class is required in `/public/index.php` which makes it accessible from every view.

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

````
ROOT/
|
├── app/
|   ├── controllers/
|   ├── exceptions/
|   ├── helpers/
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
├── .gitignore
├── .htaccess
├── composer.json
├── package.json
├── README.md
├── tailwind.config.js
└── webpack.mix.js
````

### Root

**.gitignore.example** - A template for the .gitignore.<br>
**.env** - Here goes all important credentials and information that will be used by the system. See the [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) library. This file must not be pushed to the repo!<br>
**.env.example** - This file should only contain example/placeholder data that can be pushed to a repo for sharing.<br>
**.gitignore** - Setup your gitignore to exclude files and folders that you don' want to push to the repo (lie the .env file).<br>
**.htaccess** This - file is important to point the visitors to the *~/public* folder.<br>
**composer.json** - This file contains the Composer dependencies needed for the project as well as configurations for the autoloader.<br>
**package.json** - This file contains the NPM dependencies needed for the project.<br>
**README.md** - Read Me please!<br>
**tailwind.config.js** - This file contains configurations for the Tailwind CSS compiler.<br>
**webpack.mix.js** - This file contains Browser-sync configuration and SCSS compiler settings.<br>

### /app
Here goes the app logic files. All connection to the database should be in these files since because they will not be accessible for the users.

**/controllers**<br>
Store your controller files here. The naming convention is "**UserController.php**".

**/exceptions**<br>
Store your exceptions files here.

**/helpers**<br>
Store your helper files here. For example custom functions.

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