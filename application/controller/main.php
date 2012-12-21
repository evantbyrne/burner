<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$m = new \Model\User();
		var_dump($m->get_schema());
		exit;
	
	}
	
}