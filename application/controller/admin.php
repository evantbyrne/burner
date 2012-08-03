<?php

namespace Controller;
use Core\Config;

/**
 * Admin Controller
 * @author Evan Byrne
 */
class Admin extends \Core\Controller\Base {
	
	/**
	 * Construct
	 */
	public function __construct() {
		
		Auth::enforce();
		require_once(APPLICATION . '/config/admin.php');
		
	}
	
	/**
	 * Index
	 */
	public function index() {
		
		$this->data('models', Config::get('admin'));
	
	}
	
	/**
	 * Model
	 * @param string Model
	 */
	public function model($name) {
		
		// 404 on unconfigured model
		if(!in_array($name, Config::get('admin'))) {

			$this->error(404);

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

	/**
	 * Row
	 * @param string Model
	 * @param string Row ID
	 */
	public function row($model, $id) {

		// 404 on unconfigured model
		if(!in_array($model, Config::get('admin'))) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = $model_class::id($id) or $this->error(404);
		
		$schema = $row->get_schema();
		$admin = $row->get_admin();
		$columns = array();

		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(isset($admin[$name])) {

				$columns[$name] = array(

					'options' => array_merge($column->options(), $admin[$name]),
					'value'   => (isset($row->{$name})) ? $row->{$name} : null

				);

			}

		}


		$this->data('model', $model);
		$this->data('row', $row);
		$this->data('columns', $columns);

	}

}