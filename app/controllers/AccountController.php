<?php

class AccountController extends PageController {

	private $firstNameMessage;
	private $lastNameMessage;
	private $emailMessage;

	public function __construct($dbc) {
		parent::__construct();

		// Save the database connection
		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

		// Did the user submit new contact details?
		if( isset( $_POST['update-contact'] ) ) {
			$this->processNewContactDetails();
		}


	}

	public function buildHTML() {



		echo $this->plates->render('account', $this->data);



	}

	private function processNewContactDetails() {

		// Validation
		$totalErrors = 0;

		// Validate the first name
		if( strlen($_POST['first-name']) > 50 ) {
			$this->data['firstNameMessage'] = '<p>Must be at most 50 characters</p>';
			$totalErrors++;
		}

		// Validate the last name
		if( strlen($_POST['last-name']) > 50 ) {
			$this->data['lastNameMessage'] = '<p>Must be at most 50 characters</p>';
			$totalErrors++;
		}

		// If totalErrors is still 0 (yay!)
		if( $totalErrors == 0 ) {
			// Form validation passed!
			// Time to update the database
			die('update');
		}



	}

}


