<?php

namespace App\Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {

		return new \Core\Response(\Library\Session::get('auth_user_id'));
	
	}
	
}