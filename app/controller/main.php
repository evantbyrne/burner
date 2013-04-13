<?php

namespace App\Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {

		$auth = new \Library\Auth(array('email' => 'evantbyrne@gmail.com', 'password' => \Library\Auth::hash('awesome')));
		return new \Core\Response($auth->user());
	
	}
	
}