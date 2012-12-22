<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$u = new \Model\User();
		$u->email = "evantbyrne@gmail.com";
		$u->password = "foo";
		$u->type = 25;
		var_dump($u->valid());
		exit;
	
	}
	
}