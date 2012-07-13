<?php

namespace Controller;
use Core\Config;

/**
 * Admin Controller
 * @author Evan Byrne
 */
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
		
		$this->data('models', array_keys(Config::get('admin')));
	
	}
	
	/**
	 * Model
	 * @param string Name
	 */
	public function model($name) {
		
		$model_class = "\\Model\\$name";
		$config = Config::get('admin');
		
		$this->data('columns', $config[$name]);
		$this->data('rows', $model_class::select()->order_desc('id')->fetch());
		$this->data('model', $name);
		
	}

}