<header class="bl__header header-sticky justify-content-between justify-content-lg-end gap-4" style="z-index: 1000;">
	<div class="d-flex align-items-center gap-3 d-lg-none">
		<button class="btn btn-alt-secondary btn-square" onclick="toggleSidebar()"><i class="fa-solid fa-bars fa-fw fa-lg"></i></button>
		<div class="header__logo">
			<img src="<?= ASSETS_URL ?>/images/beets_col_250x744.png" alt="Beets logotype">
		</div>
	</div>
	<div class="d-flex align-items-center gap-4">
		<?php if (auth()) : ?>
		<nav class="header__nav">
			<ul class="nav-list">
				<li class="nav-item"><a href="/about" class="nav-link">About</a></li>
				<li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
			</ul>
		</nav>
		<div class="dropdown">
			<div class="d-flex align-items-center gap-2 cursor-pointer" style="height: 38px;" data-bs-toggle="dropdown" aria-expanded="false">
				<span class="link-dark"><?= App\Models\User::fullName() ?></span>
				<?php if (App\Models\User::image()): ?>
				<img src="<?= storage(App\Models\User::image()) ?>" class="rounded-circle" width="25">
				<?php else: ?>
				<div class="d-flex justify-content-center align-items-center bg-dark rounded-circle text-white" style="width: 25px; height: 25px; font-size: 80%;"><?= App\Models\User::initials() ?></div>
				<?php endif; ?>
			</div>
			<ul class="dropdown-menu dropdown-menu-lg-end">
				<li><a class="dropdown-item" href="/profile"><i class="fa-solid fa-user fa-fw me-3"></i>Profile</a></li>
				<li><hr class="dropdown-divider"></li>
				<li>
					<form method="POST" action="/login" class="m-0">
						<?= method('DELETE') ?>
						<button class="dropdown-item"><i class="fa-solid fa-right-from-bracket fa-fw me-3"></i>Sign out</button>
					</form>
				</li>
			</ul>
		</div>
		<?php endif; ?>

		<?php if (guest()) : ?>
		<a href="/login" class="btn btn-primary">Sign in</a>
		<?php endif; ?>
	</div>
</header>