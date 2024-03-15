<?php partial('page-head'); ?>

<main class="bl__main">
	<div class="bl__body bg-transparent container-xl py-3 px-2 px-sm-4">
		<div class="d-flex justify-content-center my-5">
			<img src="<?= image('beets_col_250x744.png') ?>" style="max-height: 75px;">
		</div>

		<div class="card shadow-sm mx-auto" style="max-width: 30em">
			<div class="card-header">
				Reset your password
			</div>
			<div class="card-body">
				<p>Select a new, strong password with a min lenght of <?= PASSWORD_MIN_LENGTH ?> characters.</p>
				
				<form method="POST" action="/reset-password/new" name="reset-password-form" id="resetPasswordForm" class="mb-0">
					<?= method('PATCH') ?>
					<?= csrf() ?>
					<?= hidden("token", $_GET['token'] ?? '') ?>
					<div class="mb-3">
						<label for="password_new" class="form-label">New password <?= required() ?></label>
						<input 
							type="password" 
							class="form-control" 
							id="password_new" 
							name="password_new"
						>
					</div>
					<div class="mb-4">
						<label for="password_repeat" class="form-label">Repeat password <?= required() ?></label>
						<input 
							type="password" 
							class="form-control <?= inputErrorStyle('password_repeat') ?>" 
							id="password_repeat" 
							name="password_repeat"
						>
						<?= inputErrorMessage('password_repeat') ?>
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
			
	<?php partial('copyright'); ?>
</main>

<?php partial('page-foot'); ?>
