<img src=".github/assets/images/beetsphp_col_100x421.png#gh-light-mode-only" style="height: 80px;">
<img src=".github/assets/images/beetsphp_col_inv_100x421.png#gh-dark-mode-only" style="height: 80px;">

## About

Beets PHP is a micro framework, scaffolding and jump start to your own PHP projects. Beets PHP uses a RESTful aproach with an MVC filesystem and includes a router, autoloader, SCSS compiler, Browser-sync, Docker compatibility, a complete user administration system and more!

Also included is [Beets CSS](https://github.com/jonasbirkelof/beets-css) and [Beets Layout](https://github.com/jonasbirkelof/beets-layout) which together with [Bootstrap](https://getbootstrap.com) provides you with a completely designed user interface with collapsing sidebar, color adjustments and custom components. This being said, Beets PHP is framework agnostic so if you don't fancy Bootstrap, you can just install [Tailwind CSS](https://tailwindcss.com/) or whatever you want!

## Documentation

The full documentation for the different Beets projects can be found on the [Beets documentation website](https://docs.jonasbirkelof.se/beets).

## Dependencies

All libraries and packages are downloaded upon installation, but please take time to acknowledge these amazing people and visit their pages for more detaild documentation:

- [Bramus Router](https://github.com/bramus/router)
- [vlucas PHP dotenv](https://github.com/vlucas/phpdotenv)
- [BrowserSync](https://browsersync.io/docs) (not with Docker)
- [MailHog](https://github.com/mailhog/MailHog) (only with Docker)

## Installation

You can build your app with **Docker** or a local stack like **Xampp**. Please refer to the corresponding installation instructions since they differ a little from each other.

### Install for Docker

Follow these steps to get started with Beets PHP by using Docker.

1. Download Beets PHP by cloing the repository.

    ```bash
    git clone https://github.com/jonasbirkelof/beets-php
    ```

1. Open a terminal in the project root, navigate to the `/src` folder and install the dependencies.
    ```bash
    cd src
    ```

    ```bash
    npm install
    ```
    
    ```bash
    composer install
    ```

1. Open the file `~/config/config.php`. Update the values below under **Development variables** and **Productions variables**.

    ```php title="Example"
    $appFolder = '/subdomain';
	$dbTablePrefix = 'app_';
    ```

    - `$appFolder`: If your application lives in a subfolder to your root, set the folder name here.
    - `$dbTablePrefix`: If you only have one database available, like on a shared host, and have to give your table a prefix you set that prefix here.
    
1. Open the file `~/src/vendor/bramus/router/src/Bramus/Router.php`.

1. Find the `run()` method around line 274. 

    Replace this line:

    ```php
    $this->requestedMethod = $this->getRequestMethod();
    ```

    ...with this line and save the file:

    ```php
    $this->requestedMethod = $_POST['_method'] ?? $this->getRequestMethod();
    ```

1. Build the application to generate JavaScript and CSS files:

    ```bash
    npm run build
    ```

1. Run docker compose from the root folder.

    ```bash
    cd ..
    ```

    ```bash
    docker compose up --build -d
    ```

1. When the containers are running, open PhpMyadmin ([localhost:9001](http://localhost:9001)) and import the database file `~/src/beetsphp.sql`. Use the default login credentials:

    - Server: mysql_db
    - Username: root
    - Password: root

Open your website: [localhost:9000](http://localhost:9000).

Open MailHog: [localhost:8025](http://localhost:8025)

### Install for Xampp

Follow these steps to get started with Beets PHP by using Xampp or any other local web server.

The standard port 80 is shown for the URLs but you really don't need to have it there. If your port 80 is already in use, you have to set the Xampp port to something else (like 8080) and set the ports described below to that new port.

1. Download Beets PHP by cloing the repository.

    ```bash
    git clone https://github.com/jonasbirkelof/beets-php
    ```

1. Delete the following files and folders completely:

	- `~/phpmyadmin/`
	- `~/Dockerfile`
	- `~/docker-compose.yml`

1. Move the whole content of the `~/src/` folder to the root directory `(~/)` and delete the now empty `src` folder.

1. Open a terminal in the project root and install the dependencies.
    ```bash
    npm install
    ```

1. Open the file `~/.env`.

    a. Update `APP_URL` to the virtual host you just created:

    ```php
    APP_URL=http://beetsphp.local:80
    ```

    a. Update your database credentials. For Xampp it might look something like this:

    ```txt
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=beetsphp
    DB_CHARSET=utf8mb4
    DB_USERNAME=root
    DB_PASSWORD=
    ```

1. Open the file `~/config/config.php`. Update the values below under **Development variables** and **Productions variables**.

    ```php title="Example"
    $appFolder = '/subdomain';
	$dbTablePrefix = 'app_';
    ```

    - `$appFolder`: If your application lives in a subfolder to your root, set the folder name here.
    - `$dbTablePrefix`: If you only have one database available, like on a shared host, and have to give your table a prefix you set that prefix here.

1. Open the file `~/webpack.mix.js`.

    a. Update the BrowserSync proxy with the virtual host we just created:

    ```js
    .browserSync({
      proxy: 'beetsphp.local:80'
    ])
    ```

1. Open the router file `~/vendor/bramus/router/src/Bramus/Router.php` and find the `run()` method around line 274.

    Replace this line:

    ```php
    $this->requestedMethod = $this->getRequestMethod();
    ```
    
    ...with this line and save the file:

    ```php
    $this->requestedMethod = $_POST['_method'] ?? $this->getRequestMethod();
    ```

1. Add a virtual host for the project by adding the following code to `<path-to-xampp>/apache/conf/extra/httpd-vhosts.conf`:

    ```txt
    <VirtualHost *:80>
        DocumentRoot "<path-to-xampp-localhost>/beets-php"
        ServerName beetsphp.local
    </VirtualHost>
    ```

1. Open Notepad as an **administrator** and open the hosts file `C:\Windows\System32\drivers\etc\hosts`. You will have to change the dropdown from only showing .txt files to show all files. Add the following line to the file, save and close it.

    ```txt
    127.0.0.1 beetsphp.local
    ```

1. Start or restart Xampp with PhpMyAdmin.

1. Open PhpMyadmin ([localhost:80/phpmyadmin](localhost:80/phpmyadmin)) and import the database file `~/beetsphp.sql`.

1. Build the application to generate the JavaScript and CSS files:

    ```bash
    npm run build
    ```

You can now visit your new Beets PHP application by visiting [beetsphp.local:80](beetsphp.local:80)

1. If you want to use the dev server, start it with:

    ```bash
    npm run dev
    ```

Open your website: [localhost:3000](http://localhost:3000).