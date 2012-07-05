<?php

namespace Controller;
use Dingo\Route, Dingo\Response, Dingo\JsonResponse, Dingo\Shortcut as S, Library\Input;

class Admin {
	
	/**
	 * Construct
	 */
	public function __construct() {
		
		require_once(APPLICATION.'/config/admin.php');
		
	}
	
	/**
	 * Index
	 * @return \Dingo\Response
	 */
	public function index() {
		
		$models = \Dingo\Config::get('admin');
		return S::render_response('admin/index', array('models' => $models));
	
	}

}