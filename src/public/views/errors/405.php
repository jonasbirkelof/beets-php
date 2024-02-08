<?php

$code = 405;
$title = "Method Not Allowed";
$message = "Illegal request method";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php APP_URL ?> /views/errors/http-styles.css">
    <title><?= $code ?> <?= $title ?></title>
</head>
<body>

<main>
	<div class="container">
		<div class="wrap">
			<div class="left"><?= $code ?></div>
			<div class="right"><?= $title ?></div>
		</div>
		<div class="message">
			<?= $message ?>
		</div>
	</div>			
</main>

</body>
</html>