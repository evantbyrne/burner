<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$m = new \Model\Project();
		print_r($m->get_schema());
		exit;
	
	}
	
}