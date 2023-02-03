<?php

use App\Models\App;

?>

<header id="navigation" class="navigation-sticky">
	<div class="header-container">
		<!-- Logo -->
		<div id="logo">
			LOGO HERE
		</div>
		<!-- Navigation -->
		<nav id="top-nav">
			<ul class="nav-list">
				<li class="nav-list-item">
					<a href="/" class="<?= setActiveNavItem('/') ?>">Home</a>
				</li>
				<li class="nav-list-item">
					<a href="/users" class="<?= setActiveNavItem('/users') ?>">Users</a>
				</li>
				<li class="nav-list-item">
					<a href="/users/1" class="<?= setActiveNavItem('/users/1') ?>">Users/1</a>
				</li>
				<li class="nav-list-item">
					<a href="/products" class="<?= setActiveNavItem('/products') ?>">Products</a>
				</li>
			</ul>
		</nav>
	</div>
</header>