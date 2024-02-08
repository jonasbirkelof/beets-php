<?php require "partials/page-head.php"; ?>

<main class="bl__main">
	<div class="bl__body bg-transparent container-xl py-3 px-2 px-sm-4">
		<div class="d-flex justify-content-center my-5">
			<img src="<?= ASSETS_URL ?>/images/beets_col_250x744.png" style="max-height: 75px;">
		</div>

		<div class="card shadow-sm mx-auto" style="max-width: 30em">
			<div class="card-header">
				Sign in
			</div>
			<div class="card-body">
				<form method="POST" action="/login" name="login-form" id="loginForm" class="mb-0">
					<div class="mb-3">
						<label for="email" class="form-label">Email <?= required() ?></label>
						<input 
							type="email" 
							class="form-control" 
							id="email" 
							name="email"
						>
					</div>
					<div class="mb-4">
						<label for="password" class="form-label">Password <?= required() ?></label>
						<input 
							type="password"
							class="form-control"
							id="password"
							name="password"
						>
					</div>

					<?= feedback() ?>
	
					<div class="d-flex justify-content-start">
						<input type="submit" class="btn btn-dark" value="Sign in">
						<a class="btn btn-link link-dark" href="/reset-password">Forgot password?</a>
					</div>
				</form>
			</div>
		</div>
	</div>
			
	<?php require "partials/copyright.php"; ?>
</main>

<?php require "partials/page-foot.php"; ?>