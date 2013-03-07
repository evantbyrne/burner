<?php

namespace App\Controller;

/**
 * Error Controller
 */
class Error extends \Core\Controller\Base {

	/**
	 * 404
	 */
	public function _404() {

		$this->status_code(404);
		$this->template('error/404');

	}

	/**
	 * 403
	 */
	public function _403() {

		$this->status_code(403);
		$this->template('error/403');

	}
	
}