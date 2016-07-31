<?php 

	$this->layout('master',[
		'title'=>'Search',
		'desc'=>'Search Results'
	]);

 ?>

 <body>

<?= $this->insert('nav') ?>

<h1>Search Results for "<i><?= $this->e($searchTerm) ?></i>"</h1>

<?php if(strlen($searchTerm) > 0): ?>
	<?php if($searchResults > 0): ?>
		<?php foreach($searchResults as $Result): ?>
			<h3><?= $Result['score_title'] ?></h3>
			<p><?= $Result['score_description'] ?></p>
			<hr>
		<?php endforeach; ?>
	<?php else: ?>
		<p>There was no results for "<i><?= $this->e($searchTerm) ?></i>"</p>
	<?php endif; ?>
<?php else: ?>
	<p>Please put something into the search bar</p>
<?php endif; ?>