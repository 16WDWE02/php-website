<?php

class EditPostController extends PageController {

	public function __construct($dbc) {

		// Don't forget the parent constructor!
		// Without it you won't have plates!
		parent::__construct();

		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

		// Did the user submit the edit form?
		if( isset($_POST['edit-post']) ) {
			$this->processPostEdit();
		}

		// Get info about the post
		$this->getPostInfo();

	}

	public function buildHTML() {
		
		echo $this->plates->render('edit-post', $this->data);

	}

	private function getPostInfo() {

		// Get the POST ID from the GET array
		$postID = $this->dbc->real_escape_string($_GET['id']);

		// Get the user ID
		$userID = $_SESSION['id'];

		// Prepare the query
		$sql = "SELECT title, description, image
				FROM posts
				WHERE id = $postID
				AND user_id = $userID";

		// Run the query
		$result = $this->dbc->query($sql);

		// If the query failed
		if( !$result || $result->num_rows == 0  ) {
			// Send the user back to the post page
			// They probably didn't own this post
			// OR the post was deleted
			header("Location: index.php?page=post&postid=$postID");
		} else {

			// WAIT!
			// What if the user has submitted the form?
			// We don't want to lose their changes
			if( isset($_POST['edit-post']) ) {
				// USE THE FORM DATA!!!
				$this->data['post'] = $_POST;

				// Use the original title
				$result = $result->fetch_assoc();
				$this->data['originalTitle'] = $result['title'];


			} else {
				// Use the database data
				$result = $result->fetch_assoc();
				
				$this->data['post'] = $result;

				$this->data['originalTitle'] = $result['title'];
			}

			
		}



	}

	private function processPostEdit() {

		// Validation
		$totalErrors = 0;

		// Make life easier
		$title = $_POST['title'];
		$desc = $_POST['description'];

		// Title
		if( strlen($title) > 100 ) {
			$totalErrors++;
			$this->data['titleError'] = 'At most 100';
		}

		// Description
		if( strlen($desc) > 1000 ) {
			$totalErrors++;
			$this->data['descError'] = 'At most 1000';
		}

		// If there are no errors
		if( $totalErrors == 0 ) {

			// Filter the data
			$title  = $this->dbc->real_escape_string($title);
			$desc   = $this->dbc->real_escape_string($desc);
			$postID = $this->dbc->real_escape_string($_GET['id']);
			$userID = $_SESSION['id'];

			// Prepare the SQL
			$sql = "UPDATE posts
					SET title = '$title',
						description = '$desc'
					WHERE id = $postID
					AND user_id = $userID";

			$this->dbc->query($sql);

			// Redirect the user to the post page
			header("Location: index.php?page=post&postid=$postID");

		}

	}

}



