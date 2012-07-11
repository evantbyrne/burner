<?php

namespace Controller;

class Main extends Base {

	/**
	 * Index
	 */
	public function index() {
	
		$this->data('title', 'Kind of awesome...');
		$this->data(array('title' => 'Super awesome!'));
		$this->template('main/awesome');
	
	}
	
}