<?php

namespace Controller;
use Core\Config;

class Admin extends Base {
	
	/**
	 * Construct
	 */
	public function __construct() {
		
		require_once(APPLICATION.'/config/admin.php');
		
	}
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->data('models', Config::get('admin'));
	
	}

}