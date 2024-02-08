<?php require "partials/page-head.php"; ?>
<?php require "partials/sidebar.php"; ?>

<main class="bl__main">
	<?php require "partials/navigation.php"; ?>

	<?= feedback() ?>

	<div class="bl__body container-xl px-sm-4">
		<h1 class="page-title"><?= $title ?></h1>

		<form method="POST" enctype="multipart/form-data" name="create-user" id="createUser" class="mb-0">
			<?= csrf() ?>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">User information</h5>
					<div class="row mb-4">
						<div class="col-12 col-lg-9">
							<div class="mb-3">
								<label for="first_name" class="form-label">First name <?= required() ?></label>
								<input 
									type="text" 
									class="form-control <?= errorStyle('first_name') ?>" 
									id="first_name" 
									name="first_name" 
									maxlength="50" 
									value="<?= old('first_name') ?>"
								>
								<?= error('first_name') ?>
							</div>
							<div class="mb-3">
								<label for="last_name" class="form-label">Last name <?= required() ?></label>
								<input 
									type="text" 
									class="form-control <?= errorStyle('last_name') ?>" 
									id="last_name" 
									name="last_name"  
									maxlength="50"
									value="<?= old('last_name') ?>"
								>
								<?= error('last_name') ?>
							</div>
						</div>
						<div class="col-12 col-lg-3">
							<div class="profile-image__wrap mb-4">
								<div class="profile-image__container bg-light border">
									<img src="<?= storage($user['image']) ?>" alt="Profile image" class="profile-image <?php if (! $user['image']) echo "d-none"; ?>" id="imagePreview">
									<i class="fa-solid fa-fw fa-image fa-2x opacity-25 <?php if ($user['image']) echo "d-none"; ?>" id="imagePlaceholder"></i>
								</div>
								<div class="dropdown-center position-absolute bottom-0 end-0">
									<button class="btn btn-secondary btn-sm btn-square rounded-circle dropdown-toggle dropdown-no-caret position-absolute bottom-0 end-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="fa-solid fa-pen"></i>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a class="dropdown-item p-0">
												<label for="image" class="px-3 py-1">Upload</label>
												<input type="file" name="image" id="image" accept="image/*">
											</a>
										</li>
										<li class="d-none" id="deleteImageButton"><a class="dropdown-item" href="#" onclick="hideImage()">Remove</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<h5 class="card-title">Contact information</h5>
					<div class="mb-3">
						<label for="email" class="form-label">Email <?= required() ?></label>
						<input 
							type="text" 
							class="form-control <?= errorStyle('email') ?>" 
							id="email" 
							name="email" 
							value="<?= old('email') ?>"
						>
						<?= error('email') ?>
					</div>		
					<div class="mb-4">
						<label for="phone" class="form-label">Phone</label>
						<input 
							type="text" 
							class="form-control <?= errorStyle('phone') ?>"
							id="phone"
							name="phone"
							maxlength="17"
							value="<?= old('phone') ?>"
						>
						<?= error('phone') ?>
					</div>

					<h5 class="card-title">Password</h5>
					<p class="card-text">Select a strong password of <?= PASSWORD_MIN_LENGTH ?> to <?= PASSWORD_MAX_LENGTH ?> characters.</p>
					<div class="mb-3">
						<label for="password" class="form-label">Password <?= required() ?></label>
						<input 
							type="password" 
							class="form-control <?= errorStyle('password') ?> <?= errorStyle('password_repeat') ?>" 
							id="password" 
							name="password" 
							maxlength="<?= PASSWORD_MAX_LENGTH ?>"
						>
						<?= error('password') ?>					
					</div>
					<div class="mb-4">
						<label for="email" class="form-label">Repeat password <?= required() ?></label>
						<input 
							type="password" 
							class="form-control <?= errorStyle('password_repeat') ?>" 
							id="password_repeat" 
							name="password_repeat"
							maxlength="<?= PASSWORD_MAX_LENGTH ?>"
						>
						<?= error('password_repeat') ?>					
					</div>

					<h5 class="card-title">Security</h5>
					<div class="mb-4">
						<label for="role" class="form-label">User role <?= required() ?></label>
						<select id="role" name="role" class="form-select <?= errorStyle('role') ?>">
							<?= $rolesList ?>
						</select>
						<?= error('role') ?>	
					</div>
					<div class="mb-4">
						<label class="form-label">Status</label>
						<div class="form-check form-switch">
							<input 
								type="checkbox" 
								class="form-check-input"
								id="status" 
								name="status" 
								role="switch" 
								<?= checkboxState(old('status', 1)) ?>
							>
							<label class="form-check-label" for="status">The account is active on creation</label>
						</div>
					</div>

					<div class="d-flex justify-content-between">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>

		</form>								

	</div>
</main>

<script>
	// Preview uploaded image
	image = document.getElementById("image");
	imagePreview = document.getElementById("imagePreview");
	imagePlaceholder = document.getElementById("imagePlaceholder");
	deleteButton = document.getElementById("deleteImageButton");

	image.onchange = function(){
		imagePreview.src = URL.createObjectURL(image.files[0]);

		imagePreview.classList.remove("d-none");
		imagePlaceholder.classList.add("d-none");
		deleteButton.classList.remove("d-none");
	}

	// Remove preview of image
	function hideImage() {
		imagePreview.classList.add("d-none");
		imagePlaceholder.classList.remove("d-none");
		deleteButton.classList.add("d-none");
	}
</script>

<?php require "partials/page-foot.php"; ?>
