<?php

class LandingController {

	// Properties (attributes)
	private $emailMessage;
	private $passwordMessage;
	private $dbc;

	// Constructor
	public function __construct($dbc) {

		// Save the database connection for later
		$this->dbc = $dbc;

		// If the user has submitted the registration form
		if( isset($_POST['new-account']) ) {
			$this->validateRegistrationForm();
		}

	}


	// Methods (functions)
	public function registerAccount() {

		// Validate the user's data

		// Check the database to see if 
		// E-Mail is in use

		// Check the strength of the password

		// Register the account OR show error messages

		// If successful, log user in and redirect
		// to their brand new stream page (account)


	}

	public function buildHTML() {

		// Instantiate (create instance of) Plates library
		$plates = new League\Plates\Engine('app/templates');

		// Prepare a container for data
		$data = [];

		// If there is an E-Mail error
		if($this->emailMessage != '') {
			$data['emailMessage'] = $this->emailMessage;
		}

		// If there is a message for password
		if($this->passwordMessage != '') {
			$data['passwordMessage'] = $this->passwordMessage;
		}

		echo $plates->render('landing', $data);

	}

	private function validateRegistrationForm() {
		
		$totalErrors = 0;

		// Make sure the E-Mail has been provided
		// and is valid
		if( $_POST['email'] == '' ) {
			// E-Mail is invalid
			$this->emailMessage = 'Invalid E-Mail';
			$totalErrors++;
		}

		// Make sure the E-Mail is not in use
		$filteredEmail = $this->dbc->real_escape_string( $_POST['email'] );

		$sql = "SELECT email
				FROM users
				WHERE email = '$filteredEmail'  ";

		// Run the query
		$result = $this->dbc->query($sql);

		// If the query failed OR there is a result
		if( !$result || $result->num_rows > 0 ) {
			$this->emailMessage = 'E-Mail in use';
			$totalErrors++;
		}


		// If the password is less than 8 characters long
		if( strlen($_POST['password']) < 8 ) {
			// Password is too short
			$this->passwordMessage = 'Must be at least 8 characters';
			$totalErrors++;
		}

		// Determine if this data is valid to go into the database
		if( $totalErrors == 0 ) {

			// Validation passed! :D
			
			// Filter user data before using it in a query
			

			// Hash the password
			$hash = password_hash( $_POST['password'], PASSWORD_BCRYPT );

			// Prepare the SQL
			$sql = "INSERT INTO users (email, password)
					VALUES ('$filteredEmail', '$hash')";

			// Run the query
			$this->dbc->query($sql);

			// Check to make sure this worked


			// Log the user in
			$_SESSION['id'] = $this->dbc->insert_id;

			// Redirect the user to their stream page
			header('Location: index.php?page=stream');

		}

	}



}