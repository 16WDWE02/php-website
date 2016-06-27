<?php

class PostController extends PageController {
	
	public function __construct($dbc) {

		parent::__construct();

		$this->dbc = $dbc;

		$this->getPostData();

	}

	public function buildHTML() {

		echo $this->plates->render('post', $this->data);

	}

	private function getPostData() {

		// Filter the ID
		$postID = $this->dbc->real_escape_string( $_GET['postid'] );

		// Get info about this post
		$sql = "SELECT title, description, image, created_at, updated_at
				FROM posts
				WHERE id = $postID";

		// Run the SQL
		$result = $this->dbc->query($sql);

		// If the query failed
		if( !$result || $result->num_rows == 0 ) {
			// Redirect user to 404 page
			header('Location: index.php?page=404');
		} else {
			// Yay!
			$this->data['post'] = $result->fetch_assoc();
		}

	}





}