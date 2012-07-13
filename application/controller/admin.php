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
		
		Auth::enforce();
		require_once(APPLICATION.'/config/admin.php');
		
	}
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->data('models', Config::get('admin'));
	
	}
	
	/**
	 * Model
	 * @param string Name
	 */
	public function model($name) {
		
		// 404 on unconfigured model
		if(!in_array($name, Config::get('admin'))) {

			// TODO: Actual 404
			die('Not found.');

		}

		$model_class = "\\Model\\$name";
		$model = new $model_class();
		
		// Remove hidden columns
		$all_columns = $model->get_admin();
		$columns = array();
		foreach($all_columns as $column => $options) {

			if($options['list']) {

				$columns[$column] = $options;

			}

		}

		$this->data('columns', $columns);
		$this->data('rows', $model_class::select()->order_desc('id')->fetch());
		$this->data('model', $name);
		
	}

}