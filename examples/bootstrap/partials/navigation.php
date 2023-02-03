<?php

use App\Models\App;

?>

<nav class="navbar navbar-expand-lg navbar-dark">
	<div class="container-xl">
		<a class="navbar-brand" href="#">LOGO HERE</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
			<ul class="navbar-nav mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link <?= setActiveNavItem('/') ?>" aria-current="page" href="/">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= setActiveNavItem('/users') ?>" href="/users">Users</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= setActiveNavItem('/users/1') ?>" href="/users/1">Users/1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= setActiveNavItem('/products') ?>" href="/products">Products</a>
				</li>
			</ul>
		</div>
	</div>
</nav>