<?php $this->layout('master'); ?>

<h1>Edit post: <?= htmlentities($post['title']) ?></h1>

<form action="" method="post" enctype="multipart/form-data">
	
	<div>
		<label for="title">Title: </label>
		<input type="text" value="<?= $post['title'] ?>" id="title" name="title">
	</div>

	<div>
		<label for="desc">Description: </label>
		<textarea id="desc" name="desc"><?= $post['description'] ?></textarea>
	</div>

	<input type="file" name="image">

</form>






