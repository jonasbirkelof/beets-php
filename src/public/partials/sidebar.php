<?php if (auth()) : ?>
<aside class="bl__sidebar sidebar-collapse border-end-0">

	<div class="sidebar__header justify-content-between">
		<div class="header__logo fs-5">
			<img src="<?= ASSETS_URL ?>/images/beets_col_250x744.png" alt="Beets logotype">
		</div>
		<button class="btn btn-alt-secondary btn-square d-lg-none" onclick="toggleSidebar()"><i class="fa-solid fa-times fa-fw fa-lg"></i></button>
	</div>

	<div class="sidebar__body border-end">
		<nav class="sidebar__nav nav-style__simple nav-accent-primary">
			<ul class="nav-list mb-0">
				<li class="list-item">
					<a href="/" class="nav-link <?= setActiveNavItem(['/', '/dashboard']) ?>">
						<div class="nav-link-icon"><i class="fa-solid fa-gauge fa-fw"></i></div>
						Dashboard
					</a>
				</li>
				<?php if (permission('view_users_list') || permission('add_user')) : ?>
				<li class="list-item <?= setActiveNavItem(['/users', '/users/*'], 'open') ?>">
					<a href="#" class="nav-link nav-link__submenu <?= setActiveNavItem(['/users', '/users/*']) ?>" id="users-submenu" onclick="toggleSubmenu('users-submenu')">
						<div class="nav-link-icon"><i class="fa-solid fa-users fa-fw"></i></div>
						Users
					</a>
					<ul class="nav-list__submenu">
						<?php if (permission('view_users_list')) : ?>
						<li class="list-item"><a href="/users" class="nav-link <?= setActiveNavItem(['/users']) ?>">Users Accounts</a></li>
						<?php endif; ?>
						<?php if (permission('add_user')) : ?>
						<li class="list-item"><a href="/users/create" class="nav-link <?= setActiveNavItem(['/users/create']) ?>">New User Account</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				<li class="list-item">
					<a href="/profile" class="nav-link <?= setActiveNavItem(['/profile']) ?>">
						<div class="nav-link-icon"><i class="fa-solid fa-user fa-fw"></i></div>
						Profile
					</a>
				</li>
			</ul>
		</nav>
	</div>

	<div class="sidebar__footer border-end" style="min-height: 70px; max-height: 70px;">
		<nav class="sidebar__nav nav-style__simple nav-style__compact nav-accent-primary">
			<ul class="nav-list mb-0">
				<li class="list-item">
					<a href="/settings" class="nav-link <?= setActiveNavItem(['/settings']) ?>">
						<div class="nav-link-icon"><i class="fa-solid fa-gear fa-fw"></i></div>
						Settings
					</a>
				</li>
			</ul>
		</nav>
	</div>

</aside>
<?php endif; ?>