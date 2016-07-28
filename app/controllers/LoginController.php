<?php

class LoginController extends PageController {

	public function __construct($dbc) {

		// Make sure the PageControllers constructor still runs
		parent::__construct();

		// If the user is logged in then redirect them to their stream page
		$this->mustBeLoggedOut();

		// Save the database connection
		$this->dbc = $dbc;

		// If the login form has been submitted
		if( isset( $_POST['login'] ) ) {
			$this->processLoginForm();
		}

	}

	public function buildHTML() {

		echo $this->plates->render('login', $this->data);

	}

	private function processLoginForm() {

		$totalErrors = 0;

		// Make sure the email address has been provided
		if( strlen($_POST['email']) < 6 ) {

			// Prepare error messages
			$this->data['emailMessage'] = 'Invalid E-Mail';
			$totalErrors++;

		}

		// Make sure password is at least 8 characters
		if( strlen($_POST['password']) < 8 ) {

			$this->data['passwordMessage'] = 'Invalid password';
			$totalErrors++;

		}

		// If there are no errors
		if( $totalErrors == 0 ) {

			// Check the database for the E-Mail address
			// Get the hashed password too
			$filteredEmail = $this->dbc->real_escape_string( $_POST['email'] );

			// Prepare SQL
			$sql = "SELECT id, password
					FROM users
					WHERE email = '$filteredEmail'  ";

			// Run the query
			$result = $this->dbc->query( $sql );

			// Is there a result?
			if( $result->num_rows == 1 ) {

				// Check the password
				$userData = $result->fetch_assoc();

				// Check the password
				$passwordResult = password_verify( $_POST['password'], $userData['password'] );

				// If the result was good
				if( $passwordResult == true ) {
					// Log the user in
					$_SESSION['id'] = $userData['id'];

					header('Location: index.php?page=stream');

				} else {
					// Prepare error message
					$this->data['loginMessage'] = 'E-Mail or Password incorrect';
				}


			} else {

				// Credentials do not match our records
				$this->data['loginMessage'] = 'E-Mail or Password incorrect';

			}

		}

	}


}



