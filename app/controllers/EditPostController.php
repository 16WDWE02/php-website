<?php

class EditPostController extends PageController {

	public function __construct($dbc) {

		// Don't forget the parent constructor!
		// Without it you won't have plates!
		parent::__construct();

		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

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
			$this->data['post'] = $result->fetch_assoc();
		}



	}

}



