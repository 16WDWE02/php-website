<?php

// Make everything in the vendor folder
// available to use
require 'vendor/autoload.php';

// Instantiate (create instance of) Plates library
$plates = new League\Plates\Engine('app/templates');

// Has the user requested a page?
if( isset($_GET['page']) ) {
	// Requested page
	$page = $_GET['page'];
} else {
	// Home page
	$page = 'landing';
}

// Load the appropriate files based on page
switch($page) {

	// Landing page
	case 'landing':
	case 'register':
		echo $plates->render('landing');
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
		echo $plates->render('stream');
	break;

	default:
		echo $plates->render('error404');
	break;

}






