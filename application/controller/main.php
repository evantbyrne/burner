<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		var_dump(\Core\Event::trigger('Foo'));
		exit;
	
	}
	
}