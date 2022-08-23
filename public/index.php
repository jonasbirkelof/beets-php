<?php

use App\Models\App;

// Require Composer Autoloader
require __DIR__ . '../../vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=APP_URL?>/assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=APP_URL?>/assets/css/app.css">
    <title>Beets PHP</title>
</head>
<body>

    <div class="app">

        <!-- Header -->
        <header id="header">
            <div class="header-container">
                <!-- Logo -->
                <div id="logo">
                    LOGO HERE
                </div>
                <!-- Navigation -->
                <nav id="top-nav">
                    <ul class="nav-list">
                        <li class="nav-list-item">
                            <a href="/" class="<?=App::setActiveNavItem('/')?>">Home</a>
                        </li>
                        <li class="nav-list-item">
                            <a href="/users" class="<?=App::setActiveNavItem('/users')?>">Users</a>
                        </li>
                        <li class="nav-list-item">
                            <a href="/users/1" class="<?=App::setActiveNavItem('/users/1')?>">User/1</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Hero -->
        <section id="hero">
            <h1 class="hero-title">Hero section</h1>
        </section>

        <!-- Main -->
        <main id="main">

            <?php require __DIR__ . '../../routes/web.php'; ?>

        </main>

        <!-- Footer -->
        <footer id="footer">
            <div class="footer-container">
                <section class="footer-section">
                    <h3 class="footer-title">On the page</h3>
                    <!-- Footer Navigation -->
                    <nav id="footer-nav">
                        <ul class="nav-list">
                            <li class="nav-list-item">
                                <a href="/">Home</a>
                            </li>
                            <li class="nav-list-item">
                                <a href="/users">Users</a>
                            </li>
                            <li class="nav-list-item">
                                <a href="/users/1">User/1</a>
                            </li>
                        </ul>
                    </nav>
                </section>
                <section class="footer-section">
                    <h3 class="footer-title">Information</h3>
                    <nav id="footer-nav">
                        <ul class="nav-list">
                            <li class="nav-list-item">
                                <a href="#">About us</a>
                            </li>
                            <li class="nav-list-item">
                                <a href="#">Contact</a>
                            </li>
                            <li class="nav-list-item">
                                <a href="#">Career</a>
                            </li>
                        </ul>
                    </nav>
                </section>
                <section class="footer-section">
                    <h3 class="footer-title">Social</h3>
                    <p class="text-white opacity-50 italic">Social media icons</p>
                </section>
            </div>
        </footer>

    </div>

    <script src="./assets/js/app.js"></script>
</body>
</html>