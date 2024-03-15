<?php partial('page-head'); ?>
<?php partial('sidebar'); ?>

<main class="bl__main">	
	<?php partial('navigation'); ?>

	<?= feedback() ?>

	<div class="bl__body container-xl px-sm-4">
		<h1 class="page-title"><?= $title ?></h1>

		<form method="POST" enctype="multipart/form-data" name="edit-user-info" id="editUserInfo" class="mb-0">
			<?= method('PATCH') ?>
			<?= hidden('form', 'edit-user-info') ?>
			<?= csrf() ?>
			<div class="card mb-4">
				<div class="card-body">
					<h5 class="card-title">User information</h5>
					<div class="row">
						<div class="col-12 col-lg-9">
							<div class="mb-3">
								<label for="first_name" class="form-label">First name <?= required() ?></label>
								<input 
									type="text" 
									class="form-control <?= inputErrorStyle('first_name') ?>" 
									id="first_name" 
									name="first_name" 
									maxlength="50" 
									value="<?= old('first_name', $user['first_name']) ?>"
								>
								<?= inputErrorMessage('first_name') ?>
							</div>
							<div class="mb-3">
								<label for="last_name" class="form-label">Last name <?= required() ?></label>
								<input 
									type="text" 
									class="form-control <?= inputErrorStyle('last_name') ?>" 
									id="last_name" 
									name="last_name"  
									maxlength="50" 
									value="<?= old('last_name', $user['last_name']) ?>"
								>
								<?= inputErrorMessage('last_name') ?>
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
										<li class="<?php if (! $user['image']) echo "d-none"; ?>" id="deleteImageButton"><a class="dropdown-item" href="#" onclick="hideImage()">Remove</a></li>
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
							class="form-control <?= inputErrorStyle('email') ?>" 
							id="email" 
							name="email" 
							value="<?= old('email', $user['email']) ?>"
						>
						<?= inputErrorMessage('email') ?>
					</div>		
					<div class="mb-4">
						<label for="phone" class="form-label">Phone</label>
						<input 
							type="text" 
							class="form-control <?= inputErrorStyle('phone') ?>"
							id="phone"
							name="phone"
							maxlength="17"
							value="<?= old('phone', $user['phone']) ?>"
						>
						<?= inputErrorMessage('phone') ?>
					</div>

					<div class="d-flex justify-content-between">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>			
		</form>	
		
		<form method="POST" enctype="multipart/form-data" name="update-password" id="updatePassword" class="mb-0">
			<?= method('PATCH') ?>
			<?= hidden('form', 'update-password') ?>
			<?= csrf() ?>
			<div class="card mb-4">
				<div class="card-body">
					<h5 class="card-title">Change password</h5>
					<p class="card-text">Select a strong password between <?= PASSWORD_MIN_LENGTH ?> and <?= PASSWORD_MAX_LENGTH ?> characters.</p>
					<div class="mb-3">
						<label for="password" class="form-label">New password <?= required() ?></label>
						<input 
							type="password" 
							class="form-control <?= inputErrorStyle('password') ?>" 
							id="password" 
							name="password"
						>
						<?= inputErrorMessage('password') ?>
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

					<div class="d-flex justify-content-between">
						<button type="submit" value="update-password" class="btn btn-primary">Save</button>
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
		form = document.getElementById("editUserInfo");
		deleteImage = document.createElement("input");

		imagePreview.classList.add("d-none");
		imagePlaceholder.classList.remove("d-none");
		deleteButton.classList.add("d-none");

		// Create deleteImage checkbox and append to form
		deleteImage.setAttribute("type", "checkbox");
		deleteImage.setAttribute("name", "deleteImage");
		deleteImage.checked = true;
		deleteImage.classList.add("d-none");
		form.appendChild(deleteImage);
	}
</script>

<?php partial('page-foot'); ?>