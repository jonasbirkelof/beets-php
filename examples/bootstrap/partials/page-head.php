<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= APP_URL ?>/assets/images/favicon.ico" type="image/x-icon">
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/app.css">
    <title><?= $_ENV['APP_NAME'] ?> <?= isset($view['title']) ? " - {$view['title']}" : "" ?></title>
</head>
<body>

<div class="app">