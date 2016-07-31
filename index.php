<?php

session_start();

// Make everything in the vendor folder
// available to use
require 'vendor/autoload.php';
require 'app/controllers/PageController.php';

// Has the user requested a page?
$page = isset($_GET['page']) ? $_GET['page'] : 'landing';

// Connect to the database
$dbc = new mysqli('localhost', 'root', '', 'pinterest');

// Load the appropriate files based on page
switch($page) {

	// Landing page
	case 'landing':
	case 'register':
		require 'app/controllers/LandingController.php';
		$controller = new LandingController($dbc);
	break;

	// About page
	case 'about':
		echo $plates->render('about');
	break;

	// Contact page
	case 'contact':
		echo $plates->render('contact');
	break;

	// Login page
	case 'login':
		require 'app/controllers/LoginController.php';
		$controller = new LoginController($dbc);
	break;

	// Stream page
	case 'stream':
		require 'app/controllers/StreamController.php';
		$controller = new StreamController($dbc);
	break;

	case 'account':
		require 'app/controllers/AccountController.php';
		$controller = new AccountController($dbc);
	break;

	case 'post':
		require 'app/controllers/PostController.php';
		$controller = new PostController($dbc);
	break;

	case 'edit-comment':
		require 'app/controllers/EditCommentController.php';
		$controller = new EditCommentController($dbc);
	break;

	case 'edit-post':
		require 'app/controllers/EditPostController.php';
		$controller = new EditPostController($dbc);
	break;

	case 'search':
		require 'app/controllers/SearchController.php';
		$controller = new SearchController($dbc);
	break;

	case 'logout':
		unset($_SESSION['id']);
		unset($_SESSION['privilege']);
		header('Location: index.php');
		
	break;

	// 404
	default:
		require 'app/controllers/Error404Controller.php';
		$controller = new Error404Controller();
	break;

}


$controller->buildHTML();



