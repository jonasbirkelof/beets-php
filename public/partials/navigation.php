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
					<a href="/" class="<?=App::setActiveNavItem('/')?>">Home</a>
				</li>
				<li class="nav-list-item">
					<a href="/users" class="<?=App::setActiveNavItem('/users')?>">Users</a>
				</li>
				<li class="nav-list-item">
					<a href="/users/1" class="<?=App::setActiveNavItem('/users/1')?>">User/1</a>
				</li>
			</ul>
		</nav>
	</div>
</header>