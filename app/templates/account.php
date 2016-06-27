<?php 

	$this->layout('master', [
		'title'=>'Your account',
		'desc'=>'Change your password, review comments, add new content
				on your very own account page'
	]);

?>

<body>

<h1>Account</h1>

<form action="index.php?page=account" method="post">
	
	<h2>Update your contact details</h2>

	<label for="">First Name: </label>
	<input type="text" name="first-name" value="<?= isset($_POST['update-contact']) ? $_POST['first-name'] : '' ?>">                                

	<?= isset($firstNameMessage) ? $firstNameMessage : '' ?>

	<label for="">Last Name: </label>
	<input type="text" name="last-name" value="<?= isset($_POST['update-contact']) ? $_POST['last-name'] : '' ?>">

	<?= isset($lastNameMessage) ? $lastNameMessage : '' ?>

	<input type="submit" class="button" name="update-contact" value="Update your name">

</form>



<form action="index.php?page=account" method="post" enctype="multipart/form-data">
	
	<h2>Create new post</h2>

	<div>
		<label for="title">Title: </label>
		<input type="text" name="title" id="title">
		<?=  isset($titleMessage) ? $titleMessage : '' ?>
	</div>

	<div>
		<label for="desc">Description: </label>
		<textarea name="desc" id="desc" cols="30" rows="10"></textarea>
		<?=  isset($descMessage) ? $descMessage : '' ?>
	</div>

	<div>
		<label for="image">Image: </label>
		<input type="file" name="image[]" id="image" multiple>
		<?=  isset($fileMessage) ? $fileMessage : '' ?>
	</div>

	<input type="submit" name="new-post" value="Submit">
	<?=  isset($postMessage) ? $postMessage : '' ?>

</form>












