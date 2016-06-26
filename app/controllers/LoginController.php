<?php

class LoginController extends PageController {

	public function __construct($dbc) {

		// Make sure the PageControllers constructor still runs
		parent::__construct();

		// Save the database connection
		$this->dbc = $dbc;

	}

	public function buildHTML() {



	}

}