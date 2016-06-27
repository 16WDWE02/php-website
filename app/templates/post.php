<?php 

	$this->layout('master', [
		'title'=>'Post page',
		'desc'=>'View an individual post'
	]);

?>

<body>

<h1><?= $post['title'] ?></h1>