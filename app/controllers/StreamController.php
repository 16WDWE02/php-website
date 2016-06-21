<?php

class StreamController extends PageController {

	// Properties
	private $top5Favourites;

	// Constructor
	public function __construct($dbc) {

		// Run the parent constructor
		parent::__construct();

		$this->dbc = $dbc;

		$this->mustBeLoggedIn();
	}

	// Methods (functions)
	public function buildHTML() {

		// Get latest posts (pins)
		$allData = $this->getLatestPosts();

		$data = [];

		$data['allPosts'] = $allData;

		echo $this->plates->render('stream', $data);

	}

	private function getLatestPosts() {

		// Prepare some SQL
		$sql = "SELECT *
				FROM posts";

		// Run the SQL and capture the result
		$result = $this->dbc->query($sql);

		// Extract the results as an array
		$allData = $result->fetch_all(MYSQLI_ASSOC);

		// Return the results to the code that called this function
		return $allData;

	}

}






