<?php

class EditCommentController extends PageController {

	public function __construct($dbc) {

		// Oops, we overrode the parent constructor
		// Make sure we run it! It's important!
		parent::__construct();

		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

		$this->mustOwnComment();

		// Did the user submit the form?
		if(isset($_POST['edit-comment'])) {
			$this->processComment();
		}

	}

	public function buildHTML() {
		
		echo $this->plates->render('edit-comment', $this->data);

	}

	private function mustOwnComment() {

		// Get the logged in user ID 
		$userID = $_SESSION['id'];

		// Get the comment ID
		$commentID = $this->dbc->real_escape_string($_GET['id']);

		// Get the comment details
		$sql = "SELECT comment, post_id
				FROM comments
				WHERE id = $commentID
				AND user_id = $userID";

		// Run the query and capture the result
		$result = $this->dbc->query( $sql );

		// If there isn't a result
		if( !$result || $result->num_rows == 0 ) {
			// Redirect the user
			header('Location: index.php?page=stream');
		} else {
			$theComment = $result->fetch_assoc();

			$this->data['comment'] = $theComment['comment'];
			$this->data['post_id'] = $theComment['post_id'];
		}

	}

	private function processComment() {

		$totalErrors = 0;

		// Check the length
		if( strlen($_POST['comment']) > 1000 ) {
			$totalErrors++;
			$this->data['commentError'] = 'Must be less than 1000';
		}

		// If all is good, update the database
		if( $totalErrors == 0 ) {

			// Get the comment ID
			$commentID = $_GET['id'];

			// Get the comment
			$comment = $this->dbc->real_escape_string($_POST['comment']);

			// Prepare SQL
			$sql = "UPDATE comments
					SET comment = '$comment',
						updated_at = CURRENT_TIMESTAMP
					WHERE id = $commentID";

			$this->dbc->query($sql);

			// Redirect user back to the post
			header('Location: index.php?page=post&postid='.$this->data['post_id']);

			// that has their comment

		}

		

	}

}




