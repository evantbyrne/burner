<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		echo to_php_namespace('Burner.Model.Base');
		exit;
	
	}
	
}