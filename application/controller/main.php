<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		var_dump(trigger('Foo', array('quixotic')));
		exit;
	
	}
	
}