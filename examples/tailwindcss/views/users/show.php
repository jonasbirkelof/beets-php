<?php require "partials/page-head.php" ; ?>
<?php require "partials/navigation.php" ; ?>

<main id="main">
	<h1><?= $title ?></h1>
	<p>List a single user from the database.</p>
	<h4>Example</h4>

	<?php

	// Check if the model has returned any data
	if (!$user) {
		// Print error message
		echo "The user does not exist.";
	} else {
		// Print the requested data
		echo '<pre class="bg-slate-100 p-4 rounded-lg">';
		print_r($user);
		echo '</pre>';
	}

	?>
	
</main>

<?php require "partials/footer.php"; ?>
<?php require "partials/page-foot.php"; ?>