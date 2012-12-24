<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$a = \Model\Article::id(1) or $this->error(404);
		$this->data('title', $a->title);
	
	}
	
}