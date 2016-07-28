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
		<?php if($_SESSION['privilege'] == 'admin'): ?>
		<li>
			<a href="">View Admin messages (145)</a>
		</li>
		<?php endif; ?>
	</ul>
	<?php endif; ?>
</nav>