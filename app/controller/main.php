<?php

namespace App\Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {

		$auth = new \Library\Auth(array('email' => 'evantbyrne@gmail.com', 'password' => \App\Model\User::hash('awesome')));
		var_dump($auth->user());
		exit;
	
	}
	
}