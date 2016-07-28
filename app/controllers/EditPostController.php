<?php

use Intervention\Image\ImageManager;

class EditPostController extends PageController {

	private $acceptableImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff'];

	public function __construct($dbc) {

		// Don't forget the parent constructor!
		// Without it you won't have plates!
		parent::__construct();

		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

		// Did the user submit the edit form?
		if( isset($_POST['edit-post']) ) {
			$this->processPostEdit();
		}

		// Get info about the post
		$this->getPostInfo();

	}

	public function buildHTML() {
		
		echo $this->plates->render('edit-post', $this->data);

	}

	private function getPostInfo() {

		// Get the POST ID from the GET array
		$postID = $this->dbc->real_escape_string($_GET['id']);

		// Get the user ID
		$userID = $_SESSION['id'];

		// Prepare the query
		$sql = "SELECT title, description, image
				FROM posts
				WHERE id = $postID ";

		if( $_SESSION['privilege'] != 'admin' ) {
			$sql .= " AND user_id = $userID";
		}
		

		// Run the query
		$result = $this->dbc->query($sql);

		// If the query failed
		if( !$result || $result->num_rows == 0  ) {
			// Send the user back to the post page
			// They probably didn't own this post
			// OR the post was deleted
			header("Location: index.php?page=post&postid=$postID");
		} else {

			// WAIT!
			// What if the user has submitted the form?
			// We don't want to lose their changes
			if( isset($_POST['edit-post']) ) {
				// USE THE FORM DATA!!!
				$this->data['post'] = $_POST;

				// Use the original title
				$result = $result->fetch_assoc();
				$this->data['originalTitle'] = $result['title'];

				// Make sure we use the current image, otherwise
				// it disappears
				$this->data['post']['image'] = $result['image'];


			} else {
				// Use the database data
				$result = $result->fetch_assoc();
				
				$this->data['post'] = $result;

				$this->data['originalTitle'] = $result['title'];
			}

			
		}



	}

	private function processPostEdit() {

		// Validation
		$totalErrors = 0;

		// Make life easier
		$title = $_POST['title'];
		$desc = $_POST['description'];

		// Title
		if( strlen($title) > 100 ) {
			$totalErrors++;
			$this->data['titleError'] = 'At most 100';
		}

		// Description
		if( strlen($desc) > 1000 ) {
			$totalErrors++;
			$this->data['descError'] = 'At most 1000';
		}

		// Make sure the user has provided an image
		if( $_FILES['image']['name'] != '' ) {
			
			if( in_array( $_FILES['image']['error'], [1,3] ) ) {
				// Show error message
				// Use a switch to generate the appropriate error message
				$this->data['imageMessage'] = 'Image failed to upload';
				$totalErrors++;
			} elseif( !in_array( $_FILES['image']['type'], $this->acceptableImageTypes ) ) {
				$this->data['imageMessage'] = 'Must be an image (jpg, gif, png, tiff etc)';
				$totalErrors++;
			}
		}
		



		// If there are no errors
		if( $totalErrors == 0 ) {

			$postID = $this->dbc->real_escape_string($_GET['id']);
			// They are wasting space otherwise
			$sql = "SELECT image FROM posts WHERE id = $postID";

			// Run the query
			$result = $this->dbc->query($sql);

			// Extract the data
			$result = $result->fetch_assoc();

			// Get the image name
			$imageName = $result['image'];

			// If the user uploaded an image
			if( $_FILES['image']['name'] != '' ) {

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

				

				unlink("img/uploads/original/$imageName");
				unlink("img/uploads/stream/$imageName");

				// Change the $imageName to be the new file name
				$imageName = $fileName.$fileExtension;


			}

			// Filter the data
			$title  = $this->dbc->real_escape_string($title);
			$desc   = $this->dbc->real_escape_string($desc);
			
			$userID = $_SESSION['id'];

			// Did the user upload an image?


			// Prepare the SQL
			$sql = "UPDATE posts
					SET title = '$title',
						description = '$desc',
						image = '$imageName'
					WHERE id = $postID ";

			if($_SESSION['privilege'] != 'admin') {
				$sql .= " AND user_id = $userID";
			}
					

			$this->dbc->query($sql);

			// Validation
			if( $this->dbc->affected_rows == 0 ) {
				$this->data['updateMessage'] = 'Nothing changed';
			} else {
				// Redirect the user to the post page
				header("Location: index.php?page=post&postid=$postID");
			}

			

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



