<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$u = new \Model\User();
		$u->email = "evantbyrne@gmail.com";
		$u->get();
		var_dump($u->valid());
		exit;
	
	}
	
}