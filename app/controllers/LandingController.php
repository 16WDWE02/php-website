<?php

class LandingController {

	// Properties (attributes)

	// Constructor



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

		echo $plates->render('landing');

	}








}