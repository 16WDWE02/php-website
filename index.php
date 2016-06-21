<?php

session_start();

// Make everything in the vendor folder
// available to use
require 'vendor/autoload.php';
require 'app/controllers/PageController.php';

// Has the user requested a page?
// if( isset($_GET['page']) ) {
// 	// Requested page
// 	$page = $_GET['page'];
// } else {
// 	// Home page
// 	$page = 'landing';
// }

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
		echo $plates->render('login');
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

	default:
		echo $plates->render('error404');
	break;

}


$controller->buildHTML();



