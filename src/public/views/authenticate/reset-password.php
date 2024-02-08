<?php require "partials/page-head.php"; ?>

<main class="bl__main">
	<div class="bl__body bg-transparent container-xl py-3 px-2 px-sm-4">
		<div class="d-flex justify-content-center my-5">
			<img src="<?= ASSETS_URL ?>/images/beets_col_250x744.png" style="max-height: 75px;">
		</div>

		<div class="card shadow-sm mx-auto" style="max-width: 30em">
			<div class="card-header">
				Reset your password
			</div>
			<div class="card-body">
				<p>Do you need to reset your account password? submit your registered email address below. You will get an email with instructions on how to reset your password.</p>
				
				<form method="POST" action="/reset-password" name="reset-password-form" id="resetPasswordForm" class="mb-0">
					<?= csrf() ?>
					<div class="mb-4">
						<label for="email" class="form-label">Email <?= required() ?></label>
						<input 
							type="email" 
							class="form-control" 
							id="email" 
							name="email"
						>
					</div>

					<?= feedback() ?>
	
					<div class="d-flex justify-content-start">
						<input type="submit" class="btn btn-dark" value="Submit">
						<a href="/login" class="btn btn-link link-dark">Sign in</a>
					</div>
				</form>
			</div>		
		</div>	
	</div>

	<?php require "partials/copyright.php"; ?>
</main>

<?php require "partials/page-foot.php"; ?>
