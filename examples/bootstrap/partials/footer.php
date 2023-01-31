<!-- Footer -->
<footer id="footer" class="px-2 px-sm-0">
	<div class="container-xl d-flex">
		<section class="footer-section py-5">
			<h3 class="footer-title mb-3 fs-5">On the page</h3>
			<!-- Footer Navigation -->
			<nav id="footer-nav">
				<ul class="nav-list">
					<li class="nav-list-item">
						<a href="/">Home</a>
					</li>
					<li class="nav-list-item">
						<a href="/users">Users</a>
					</li>
					<li class="nav-list-item">
						<a href="/products">Products</a>
					</li>
				</ul>
			</nav>
		</section>
		<section class="footer-section py-5">
			<h3 class="footer-title mb-3 fs-5">Information</h3>
			<nav id="footer-nav">
				<ul class="nav-list">
					<li class="nav-list-item">
						<a href="#">About us</a>
					</li>
					<li class="nav-list-item">
						<a href="#">Contact</a>
					</li>
					<li class="nav-list-item">
						<a href="#">Career</a>
					</li>
				</ul>
			</nav>
		</section>
		<section class="footer-section py-5">
			<h3 class="footer-title mb-3 fs-5">Social</h3>
			<p>Social media icons</p>
		</section>
	</div>
</footer>
<section id="copyright" class="py-2">
	&copy; <?= $_ENV['APP_COPYRIGHT'] ?> <?= date('Y') ?>
</section>