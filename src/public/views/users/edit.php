<?php require "partials/page-head.php"; ?>
<?php require "partials/sidebar.php"; ?>

<main class="bl__main">	
	<?php require "partials/navigation.php"; ?>

	<?= feedback() ?>

	<div class="bl__body container-xl px-sm-4">
		<?= breadcrumbs($breadcrumbs) ?>
		<h1 class="page-title d-flex align-items-center justify-content-between">
			<?= $title ?>
			<?php if (permission('delete_user') && $user['id'] != App\Models\User::id()): ?>
			<button type="button" class="btn btn-sm btn-alt-danger" data-bs-toggle="modal" data-bs-target="#deleteUserConfirm"><i class="fa-solid fa-trash me-2"></i>Delete account</button>
			<?php endif; ?>
		</h1>

		<form method="POST" enctype="multipart/form-data" name="edit-user-info" id="editUserInfo" class="mb-0">
			<?= method('PATCH') ?>
			<?= hidden('form', 'edit-user-info') ?>
			<?= csrf() ?>
			<div class="card mb-4">
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
									value="<?= old('first_name', $user['first_name']) ?>"
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
									value="<?= old('last_name', $user['last_name']) ?>"
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
							class="form-control <?= errorStyle('email') ?>" 
							id="email" 
							name="email" 
							value="<?= old('email', $user['email']) ?>"
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
							value="<?= old('phone', $user['phone']) ?>"
						>
						<?= error('phone') ?>
					</div>

					<h5 class="card-title">Security</h5>
					<div class="mb-4">
						<label for="role" class="form-label">User role <?= required() ?></label>
						<select id="role" name="role" class="form-select <?= errorStyle('role') ?>">
							<?= $rolesList ?>
						</select>
						<?= error('role') ?>
					</div>
					<p>If the user account is deactivated, the user can't sign in to the app. All of the user's content will remain.</p>
					<div class="mb-4">
						<label class="form-label">Status</label>
						<div class="form-check form-switch">
							<input 
								type="checkbox" 
								class="form-check-input"
								id="status" 
								name="status" 
								role="switch" 
								<?= checkboxState(old('status', $user['status'])) ?>
							>
							<label class="form-check-label" for="status">The account is active</label>
						</div>
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

<!-- Delete user confirmation modal -->
<?php if (permission('delete_user')): ?>
<div class="modal fade" id="deleteUserConfirm" tabindex="-1" aria-labelledby="deleteUserConfirmation" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="deleteUserConfirmation">Delete user account</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Te user account will be deleted. All of the user's content will remain.</p>
				<p>Only delete the account if the user has not created any content since it will leave "orphans" without a valid user ID.</p>
				<p class="fw-bold">You can deactivate the user account to just prevent the user from signing in.</p>
				<p class="fw-bold">This action can not be undone!</p>
			</div>
			<div class="modal-footer justify-content-between">
				<form method="POST" name="delete-user" id="deleteUser">
					<?= method('DELETE') ?>
					<?= csrf() ?>
					<button type="submit" class="btn btn-danger">Delete</button>
				</form>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

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

<?php require "partials/page-foot.php"; ?>