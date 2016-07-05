<?php

use Intervention\Image\ImageManager;

class AccountController extends PageController {

	private $acceptableImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff'];

	public function __construct($dbc) {
		parent::__construct();

		// Save the database connection
		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

		// Did the user submit new contact details?
		if( isset( $_POST['update-contact'] ) ) {
			$this->processNewContactDetails();
		}

		// Did the user submit the new post form?
		if( isset($_POST['new-post']) ) {
			$this->processNewPost();
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
			$firstName = $this->dbc->real_escape_string($_POST['first-name']);
			$lastName = $this->dbc->real_escape_string($_POST['last-name']);

			$userID = $_SESSION['id'];

			// Prepare the SQL
			$sql = "UPDATE users
					SET first_name = '$firstName',
						last_name = '$lastName'
					WHERE id = $userID  ";

			// Run the query
			$this->dbc->query( $sql );

		}

	}

	private function processNewPost() {

		// Count errors
		$totalErrors = 0;

		$title = trim($_POST['title']);
		$desc  = trim($_POST['desc']);

		// Title
		if( strlen(  $title  ) == 0 ) {
			$this->data['titleMessage'] = '<p>Required</p>';
			$totalErrors++;
		} elseif( strlen(  $title  ) > 100 ) {
			$this->data['titleMessage'] = '<p>Cannot be more than 100 characters</p>';
			$totalErrors++;
		}

		// Description
		if( strlen(  $desc  ) == 0 ) {
			$this->data['descMessage'] = '<p>Required</p>';
			$totalErrors++;
		} elseif( strlen(  $desc  ) > 1000 ) {
			$this->data['descMessage'] = '<p>Cannot be more than 1000 characters</p>';
			$totalErrors++;
		}

		// Make sure the user has provided an image
		if( in_array( $_FILES['image']['error'], [1,3,4] ) ) {
			// Show error message
			// Use a switch to generate the appropriate error message
			$this->data['imageMessage'] = 'Image failed to upload';
			$totalErrors++;
		} elseif( !in_array( $_FILES['image']['type'], $this->acceptableImageTypes ) ) {
			$this->data['imageMessage'] = 'Must be an image (jpg, gif, png, tiff etc)';
			$totalErrors++;
		}


		// If there are no errors
		if( $totalErrors == 0 ) {

			// Instance of Intervention Image
			$manager = new ImageManager();

			// Get the file that was just uploaded
			$image = $manager->make( $_FILES['image']['tmp_name'] );

			$fileExtension = $this->getFileExtension( $image->mime() );

			$fileName = uniqid();

			$image->save("img/uploads/original/$fileName$fileExtension");

			$image->resize(320, null, function ($constraint) {
			    $constraint->aspectRatio();
			});

			$image->save("img/uploads/stream/$fileName$fileExtension");

			// Filter the data
			$title = $this->dbc->real_escape_string($title);
			$desc = $this->dbc->real_escape_string($desc);

			// Get the ID of logged in user
			$userID = $_SESSION['id'];

			// SQL (INSERT)
			$sql = "INSERT INTO posts (title, description, user_id, image)
					VALUES ('$title', '$desc', $userID, '$fileName$fileExtension') ";

			$this->dbc->query( $sql );

			// Make sure it worked
			if( $this->dbc->affected_rows ) {
				$this->data['postMessage'] = 'Success!';
			} else {
				$this->data['postMessage'] = 'Something went wrong!';
			}


			// Success message! (or error message)

		}



	}

	private function getFileExtension( $mimeType ) {

		switch($mimeType) {

			case 'image/png':
				return '.png';
			break;

			case 'image/gif':
				return '.gif';
			break;

			case 'image/jpeg':
				return '.jpg';
			break;

			case 'image/bmp':
				return '.bmp';
			break;

			case 'image/tiff':
				return '.tif';
			break;

		}

	}

}


