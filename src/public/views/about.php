<?php require "partials/page-head.php"; ?>
<?php require "partials/sidebar.php"; ?>

<main class="bl__main">	
	<?php require "partials/navigation.php"; ?>

	<div class="bl__body container-xl px-sm-4">
		<h1 class="page-title"><?= $title ?></h1>
		<div class="card">
			<div class="card-body">
				<p>This is the About page. It can only be visited when logged in.</p>
			</div>
		</div>
	</div>
</main>

<?php require "partials/page-foot.php"; ?>