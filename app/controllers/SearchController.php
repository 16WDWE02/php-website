<?php

class SearchController extends PageController{

	public function __construct($dbc){
		parent::__construct();

		// Save the database connection
		$this->dbc = $dbc;

		$this->mustBeLoggedIn();

		$this->getSearch();

	}

	//Methods (functions)
	public function buildHTML(){
		echo $this->plates->render('search', $this->data);
	}

	public function getSearch(){
		if(strlen($_POST['search']) === 0){
			$searchTerm = "";
		} else {
			$result = $_POST['search'];
			$searchTerm = strtolower($result);
		}

		$this->data['searchTerm'] = $searchTerm;

		$sql = "SELECT posts.id, title AS score_title, description AS score_description
				FROM posts
				WHERE 
					title LIKE '%$searchTerm%' OR
					description LIKE '%$searchTerm%'
				ORDER BY score_title ASC";

		$result = $this->dbc->query($sql);

		if( !$result || $result->num_rows == 0){
			$this->data['searchResults'] = "No Results";
		} else{
			$this->data['searchResults'] = $result->fetch_all(MYSQLI_ASSOC);
		}

	}













}
