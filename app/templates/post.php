<?php 

	$this->layout('master', [
		'title'=>'Post page',
		'desc'=>'View an individual post'
	]);

?>

<body>

<h1><?= $post['title'] ?></h1>

<p><?= $post['description'] ?></p>

<img src="img/uploads/highres/<?= $post['image'] ?>" alt="">

<ul>
	<li>Post created: <?= $post['created_at'] ?></li>
	<li>Post last updated: <?= $post['updated_at'] ?></li>
	<li>Posted by: <?= $post['first_name'].' '.$post['last_name']   ?></li>
</ul>