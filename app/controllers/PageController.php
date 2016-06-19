<?php

abstract class PageController {

	protected $title;
	protected $metaDesc;
	protected $dbc;

	// Force children classes to have the buildHTML function
	abstract public function buildHTML();

}