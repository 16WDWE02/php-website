<?php

class PostController extends PageController {
	
	public function __construct($dbc) {

		parent::__construct();

		$this->dbc = $dbc;

		// Did the user add a comment?
		if( isset($_POST['new-comment']) ) {
			$this->processNewComment();
		}

		$this->getPostData();

		


	}

	public function buildHTML() {

		echo $this->plates->render('post', $this->data);

	}

	private function getPostData() {

		// Filter the ID
		$postID = $this->dbc->real_escape_string( $_GET['postid'] );

		// Get info about this post
		$sql = "SELECT title, description, image, created_at, updated_at, first_name, last_name
				FROM posts
				JOIN users
				ON user_id = users.id
				WHERE posts.id = $postID";

		// Run the SQL
		$result = $this->dbc->query($sql);

		// If the query failed
		if( !$result || $result->num_rows == 0 ) {
			// Redirect user to 404 page
			header('Location: index.php?page=404');
		} else {
			// Yay!
			$this->data['post'] = $result->fetch_assoc();

			// If the user does not have a name
			$fName = $this->data['post']['first_name'];
			$lName = $this->data['post']['last_name'];

			// If the user does not have a name
			if( !$fName && !$lName ) {
				// Anon
				$this->data['post']['first_name'] = 'Anon';
			}

			
		}

		// Get all the comments!
		$sql = "SELECT user_id, comment, CONCAT(first_name, ' ', last_name) AS author
				FROM comments
				JOIN users
				ON comments.user_id = users.id
				WHERE post_id = $postID
				ORDER BY created_at DESC
				";

		$result = $this->dbc->query($sql);

		// Extract the data as an associative array
		$this->data['allComments'] = $result->fetch_all(MYSQLI_ASSOC);


	}

	private function processNewComment() {

		// Validate the comment
		$totalErrors = 0;

		// Minimum length

		// Maximum length (1000)

		// If passed, add to database
		if( $totalErrors == 0 ) {

			// Filter the comment
			$comment = $this->dbc->real_escape_string($_POST['comment']);
			$userID = $_SESSION['id'];
			$postID = $this->dbc->real_escape_string( $_GET['postid'] );

			// Prepare SQL
			$sql = "INSERT INTO comments (comment, user_id, post_id)
					VALUES ('$comment', $userID, $postID)";

			// Run the SQL
			$this->dbc->query($sql);

			// Make sure the query worked


		}


	}



}