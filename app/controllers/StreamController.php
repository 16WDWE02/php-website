<?php

class StreamController extends PageController {

	// Properties
	private $top5Favourites;

	// Constructor
	public function __construct($dbc) {
		$this->dbc = $dbc;

		// If you are not logged in
		if( !isset($_SESSION['id']) ) {
			// Redirect the user to the login page
			header('Location: index.php?page=login');
		}
	}

	// Methods (functions)
	public function buildHTML() {

	}

}