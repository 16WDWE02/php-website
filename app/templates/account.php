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







