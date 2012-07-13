<?php

namespace Controller;

class Main extends Base {

	/**
	 * Index
	 */
	public function index() {
	
		$this->data(array('title' => (Auth::logged_in()) ? 'Welcome, ' . Auth::user()->email : 'Super awesome!'));
		$this->template('main/awesome');
	
	}
	
}