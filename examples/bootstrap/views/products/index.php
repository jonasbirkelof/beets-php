<?php require "partials/page-head.php" ; ?>
<?php require "partials/navigation.php" ; ?>

<main id="main" class="container-xl py-3 px-0 px-sm-2">
	<h1 class="mb-4"><?= $title ?></h1>
	<p>List all products in the $products array (~/app/config/data.php).</p>
	<h4>Example</h4>
	
	<?php

	// Check if the model has returned any data
	if (!$productsList) {
		// Print error message
		echo "No products in array.";
	} else {
		// Print the requested data
		echo '<pre class="bg-light rounded-3 p-4">';
		print_r($productsList);
		echo '</pre>';
	}

	?>

</main>

<?php require "partials/footer.php"; ?>
<?php require "partials/page-foot.php"; ?>