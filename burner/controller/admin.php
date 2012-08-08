<?php

namespace Core\Controller;
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
		
		Auth::enforce('admin');
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
	 * Children
	 * @param string Parent model
	 * @param string Parent row ID
	 * @param string Model
	 */
	public function children($parent_model, $parent_id, $name) {
		
		// 404 on unconfigured model
		if(!in_array($name, Config::get('admin'))) {

			$this->error(404);

		}

		$model_class = "\\Model\\$name";
		$model = new $model_class();
		$rows = $model_class::select()->where($parent_model, '=', $parent_id)->order_desc('id')->fetch();
		
		// Remove hidden columns
		$all_columns = $model->get_admin();
		$columns = array();
		foreach($all_columns as $column => $options) {

			if($options['list']) {

				$columns[$column] = $options;

			}

		}

		$this->data('columns', $columns);
		$this->data('rows', $rows);
		$this->data('model', $name);
		$this->template('admin/model');
		
	}

	/**
	 * Edit
	 * @param string Model
	 * @param string Row ID
	 */
	public function edit($model, $id) {

		// 404 on unconfigured model
		if(!in_array($model, Config::get('admin'))) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = $model_class::id($id) or $this->error(404);
		
		$schema = $row->get_schema();
		$admin = $row->get_admin();
		$columns = array();
		$children = array();

		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(isset($admin[$name])) {
				
				if(is_a($column, '\\Column\\HasMany')) {
				
					// HasMany columns
					$children[$column->column_name()] = strtolower($column->get_option('model'));
				
				} else {
				
					// All other columns
					$columns[$name] = array('options' => array_merge($column->options(), $admin[$name]));
					$columns[$name]['value'] = (isset($row->{$name})) ? $row->{$name} : null;

				}

			}

		}

		if(is_post()) {

			$row->merge_post(array_keys($columns));
			
			if($this->valid($row)) {

				$row->save();
				redirect("admin/$model");

			} else {

				foreach($columns as $name => $value) {
					
					$columns[$name]['value'] = $row->{$name};

				}

			}

		}

		$this->data('model', $model);
		$this->data('row', $row);
		$this->data('columns', $columns);
		$this->data('children', $children);

	}

	/**
	 * Delete
	 * @param string Model
	 * @param string Row ID
	 */
	public function delete($model, $id) {

		// 404 on unconfigured model
		if(!in_array($model, Config::get('admin'))) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = $model_class::id($id) or $this->error(404);

		if(is_post()) {

			$model_class::delete()->where('id', '=', $id)->limit(1)->execute();
			redirect("admin/$model");

		} else {

			$this->data('model', $model);
			$this->data('id', $id);

		}

	}

	/**
	 * Add
	 * @param string Model
	 */
	public function add($model) {

		// 404 on unconfigured model
		if(!in_array($model, Config::get('admin'))) {

			$this->error(404);

		}

		$model_class = "\\Model\\$model";
		$row = new $model_class();
		
		$schema = $row->get_schema();
		$admin = $row->get_admin();
		$columns = array();
		$children = array();

		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(isset($admin[$name])) {
				
				if(is_a($column, '\\Column\\HasMany')) {
				
					// HasMany columns
					$children[$column->column_name()] = strtolower($column->get_option('model'));
				
				} else {
				
					// All other columns
					$columns[$name] = array(
						
						'options' => array_merge($column->options(), $admin[$name]),
						'value'   => null
					
					);

				}

			}

		}

		if(is_post()) {

			$row->merge_post(array_keys($columns));
			
			if($this->valid($row)) {

				$id = $row->save();
				redirect("admin/$model");

			} else {

				foreach($columns as $name => $value) {
					
					$columns[$name]['value'] = $row->{$name};

				}

			}

		}
		
		$this->data('model', $model);
		$this->data('row', $row);
		$this->data('columns', $columns);
		$this->data('children', $children);

	}

}