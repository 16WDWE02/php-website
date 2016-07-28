<nav>
	<?php if(isset($_SESSION['id'])): ?>
	<ul>
		<li>
			<a href="index.php?page=stream">Stream</a>
		</li>
		<li>
			<a href="index.php?page=account">Account</a>
		</li>
		<li>
			<a href="index.php?page=logout">Logout</a>
		</li>
	</ul>
	<?php endif; ?>
</nav>