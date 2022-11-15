<?php require "partials/page-head.php" ; ?>
<?php require "partials/navigation.php" ; ?>

<main id="main">
	<h1><?= $view['title'] ?></h1>
	<p>List a single user.</p>
	<h4>Example</h4>

	<?php

	// Check if the model has returned any data
	if (!$data) {
		die('The user does not exist.');
	}

	// Print the requested data
	echo '<pre class="bg-slate-100 p-4 rounded-lg">';
	print_r($data);
	echo '</pre>';

	?>
	
</main>

<?php require "partials/footer.php"; ?>
<?php require "partials/page-foot.php"; ?>