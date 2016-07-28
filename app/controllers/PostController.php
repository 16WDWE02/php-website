<?php

class PostController extends PageController {
	
	public function __construct($dbc) {

		parent::__construct();

		$this->dbc = $dbc;

		// Does the user want to delete this post?
		if( isset($_GET['delete']) ) {
			$this->deletePost();
		}

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
		$sql = "SELECT title, description, image, created_at, updated_at, first_name, last_name, user_id
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
		$sql = "SELECT comments.id, user_id, comment, CONCAT(first_name, ' ', last_name) AS author
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

	private function deletePost() {

		// If user is not logged in
		if( !isset($_SESSION['id']) ) {
			return;
		}

		// Make sure the user owns this post
		$postID = $this->dbc->real_escape_string($_GET['postid']);
		$userID = $_SESSION['id'];
		$privilege = $_SESSION['privilege'];

		// Delete the image first
		$sql = "SELECT image
				FROM posts
				WHERE id = $postID";

		// If the user is not an admin
		if( $privilege != 'admin' ) {
			$sql .= " AND user_id = $userID";
		}

		// Run this query
		$result = $this->dbc->query($sql);

		// If the query failed
		// Either post doesn't exist, or you don't own the post
		if( !$result || $result->num_rows == 0 ) {
			return;
		}

		$result = $result->fetch_assoc();

		$filename = $result['image'];

		unlink("img/uploads/original/$filename");
		unlink("img/uploads/stream/$filename");


		// Prepare the SQL
		$sql = "DELETE FROM posts
				WHERE id = $postID";

		// Run the query
		$this->dbc->query($sql);

		// Redirect the user back to stream
		// This post is dead :(
		header('Location: index.php?page=stream');
		die();



	}




}





