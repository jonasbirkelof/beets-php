<?php

use App\Models\App;

?>

<nav class="navbar">
	<div class="logo">LOGO HERE</div>
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link <?= App::setActiveNavItem('/') ?>" aria-current="page" href="/">Home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?= App::setActiveNavItem('/users') ?>" href="/users">Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?= App::setActiveNavItem('/users/1') ?>" href="/users/1">Users/1</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?= App::setActiveNavItem('/products') ?>" href="/products">Products</a>
		</li>
	</ul>
</nav>