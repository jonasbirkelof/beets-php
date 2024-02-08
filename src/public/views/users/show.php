<?php require "partials/page-head.php"; ?>
<?php require "partials/sidebar.php"; ?>

<main class="bl__main">	
	<?php require "partials/navigation.php"; ?>

	<?= feedback() ?>

	<div class="bl__body container-xl px-sm-4">
		<?= breadcrumbs($breadcrumbs) ?>
		<h1 class="page-title d-flex align-items-center justify-content-between">
			<?= $title ?>
			<?php if (permission('edit_user')): ?>
			<a href="/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen me-2"></i>Edit user</a>
			<?php endif; ?>
		</h1>

		<?php if ($user['password_reset_token']) : ?>
		<div class="callout callout-info">
			<div class="callout-header">
				An email for password reset has been sent <?= $user['password_reset_token_created_at'] ?>. The token expires <?= $user['password_reset_token_expire_at'] ?>.
			</div>
		</div>
		<?php endif; ?>

		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title">User information</h5>
				<div class="row">
					<div class="col-12 col-lg-9 mb-4 mb-lg-0">
						<dl class="row">
							<dt class="col-12 col-lg-4">Name</dt>
							<dd class="col-12 col-lg-8"><?= $user['full_name'] ?></dd>

							<dt class="col-12 col-lg-4">UUID</dt>
							<dd class="col-12 col-lg-8"><?= $user['id'] ?></dd>

							<dt class="col-12 col-lg-4">Created at</dt>
							<dd class="col-12 col-lg-8"><?= $user['created_by_string'] ?: '<small class="text-muted">n/a</small>' ?></dd>

							<dt class="col-12 col-lg-4">Latset update at</dt>
							<dd class="col-12 col-lg-8"><?= $user['updated_by_string'] ?: '<small class="text-muted">n/a</small>' ?></dd>

							<dt class="col-12 col-lg-4">Latest login</dt>
							<dd class="col-12 col-lg-8"><?= $user['last_login'] ?: '<span class="small text-muted">The user have never signed in</span>' ?></dd>
						</dl>
					</div>
					<div class="col-12 col-lg-3">
						<div class="profile-image__wrap mb-4">
							<div class="profile-image__container bg-light border">
								<?php if ($user['image']): ?>
								<img src="<?= storage($user['image']) ?>" alt="Profile image" class="profile-image">
								<?php else: ?>
								<span class="display-5 text-dark text-opacity-25"><?= $user['initials'] ?></span>
								<?php endif; ?>											
							</div>
						</div>
					</div>
				</div>

				<h5 class="card-title">Contact information</h5>
				<dl class="row">
					<dt class="col-12 col-lg-3">Email</dt>
					<dd class="col-12 col-lg-9"><?= $user['email'] ?><?php if ($user['email']) echo "<a href=\"mailto:" . $user['email'] . "\" class=\"float-end text-decoration-none small\">Send email</a>"; ?></dd>

					<dt class="col-12 col-lg-3">Phone</dt>
					<dd class="col-12 col-lg-9"><?= $user['phone'] ?: '<small class="text-muted">n/a</small>' ?></dd>
				</dl>

				<h5 class="card-title">Security</h5>
				<dl class="row mb-0">
					<dt class="col-12 col-lg-3">User role</dt>
					<dd class="col-12 col-lg-9"><?= $user['role']['long_name'] ?> (<?= $user['role']['name'] ?>)</dd>
					<dt class="col-12 col-lg-3">Status</dt>
					<dd class="col-12 col-lg-9"><?= userAccountStatusIcon($user['status']) ?> <?= userAccountStatus($user['status'])['title'] ?></dd>
				</dl>
			</div>
		</div>
	
	</div>
</main>

<?php require "partials/page-foot.php"; ?>