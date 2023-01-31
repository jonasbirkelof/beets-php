<?php require "partials/page-head.php" ; ?>
<?php require "partials/navigation.php" ; ?>

<main id="main">
	<h1><?= $view['title'] ?></h1>
	<p>List a single user from the database.</p>
	<h4>Example</h4>

	<?php

	// Check if the model has returned any data
	if (!$data) {
		// Print error message
		echo "The user does not exist.";
	} else {
		// Print the requested data
		echo '<pre style="background-color: #f3f3f3; padding: 1rem;">';
		print_r($data);
		echo '</pre>';
	}

	?>
	
</main>

<?php require "partials/footer.php"; ?>
<?php require "partials/page-foot.php"; ?>