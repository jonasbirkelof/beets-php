<?php require "partials/page-head.php"; ?>
<?php require "partials/sidebar.php"; ?>

<main class="bl__main">	
	<?php require "partials/navigation.php"; ?>
	
	<?= feedback() ?>

	<div class="bl__body container-xl px-sm-4">
		<h1 class="page-title d-flex align-items-center justify-content-between">
			<?= $title ?>
			<?php if (permission('add_user')): ?>
			<a href="/users/create" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus me-2"></i>New user account</a>
			<?php endif; ?>
		</h1>

		<?php if (!$activeUsers && ! $inactiveUsers) : ?>
		<div class="callout callout-failure">
			<div class="callout-header">
				No users in database
			</div>
		</div>
		<?php else : ?>		
		<ul class="nav nav-underline ms-2" role="tablist">
			<li class="nav-item">
				<button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#active-users-tab-pane" role="tab">
					Active <span class="badge rounded-pill text-bg-primary"><?= count($activeUsers) ?></span>
				</button>
			</li>
			<li class="nav-item">
				<button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#inactive-users-tab-pane" role="tab">
					Inactive <span class="badge rounded-pill text-bg-secondary"><?= count($inactiveUsers) ?></span>
				</button>
			</li>
		</ul>

		<div class="card tab-content">
			<div class="tab-pane show active" id="active-users-tab-pane" role="tabpanel" tabindex="0">
				<div class="card-body">
					<?php if ($activeUsers) : ?>
					<p>Active user accounts are listed below.</p>
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th width="25">&nbsp;</th>
								<th>Name</th>
								<th>Email</th>
								<th>User role</th>
								<th width="170">Latest login</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($activeUsers as $user) : ?>
							<tr>
								<td class="bg-transparent py-0 pe-1 align-middle">
									<?php if ($user['image']): ?>
									<img src="<?= storage($user['image']) ?>" class="rounded-circle" width="25">
									<?php else: ?>
									<div class="d-flex justify-content-center align-items-center bg-dark rounded-circle text-white" style="width: 25px; height: 25px; font-size: 80%;"><?= $user['initials'] ?></div>
									<?php endif; ?>
								</td>
								<td class="bg-transparent">
									<?php if (permission('view_user')) : ?>
									<a href="/users/<?= $user['id'] ?>" class="text-decoration-none"><?= $user['full_name'] ?></a>
									<?php else : ?>
									<?= $user['full_name'] ?>
									<?php endif; ?>
									<?= $user['password_reset'] ? "<i class=\"fa-solid fa-key ms-1 text-warning\" data-bs-toggle=\"tooltip\" data-bs-offset=\"0, 10\" data-bs-title=\"An email for password reset has been sent\"></i>" : null ?>
								</td>
								<td class="bg-transparent"><?= $user['email'] ?></td>
								<td class="bg-transparent"><?= $user['role']['name'] ?></td>
								<td class="bg-transparent"><?= $user['last_login'] ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php else : ?>
					<div class="callout callout-info">
						<div class="callout-header">
							No active users
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="tab-pane" id="inactive-users-tab-pane" role="tabpanel" tabindex="0">
				<div class="card-body">
					<?php if ($inactiveUsers) : ?>
					<p>Inactive user accounts are listed below.</p>
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th width="25">&nbsp;</th>
								<th>Name</th>
								<th>Email</th>
								<th width="170">Latest login</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($inactiveUsers as $user) : ?>
							<tr>
								<td class="bg-transparent py-0 pe-1 align-middle">
									<?php if ($user['image']): ?>
									<img src="<?= storage($user['image']) ?>" class="rounded-circle" width="25">
									<?php else: ?>
									<div class="d-flex justify-content-center align-items-center bg-dark rounded-circle text-white" style="width: 25px; height: 25px; font-size: 80%;"><?= $user['initials'] ?></div>
									<?php endif; ?>
								</td>
								<td class="bg-transparent">
									<?php if (permission('view_user')) : ?>
									<a href="/users/<?= $user['id'] ?>" class="text-decoration-none"><?= $user['full_name'] ?></a>
									<?php else : ?>
									<?= $user['full_name'] ?>
									<?php endif; ?>
									<?= $user['password_reset'] ? "<i class=\"fa-solid fa-key ms-1 text-warning\" data-bs-toggle=\"tooltip\" data-bs-offset=\"0, 10\" data-bs-title=\"An email for password reset has been sent\"></i>" : null ?>
								</td>
								<td class="bg-transparent"><?= $user['email'] ?></td>
								<td class="bg-transparent"><?= $user['last_login'] ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php else : ?>
					<div class="callout callout-info">
						<div class="callout-header">
							No inactive users
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</main>

<?php require "partials/page-foot.php"; ?>