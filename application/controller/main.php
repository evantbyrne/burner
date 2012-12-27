<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$a = new \Form\Article();
		$a->title = "Cool";
		$a->content = "Very Awesome!";
		var_dump($a->valid());
		exit;
	
	}
	
}