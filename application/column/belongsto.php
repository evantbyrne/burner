<?php

namespace Column;

/**
 * Has Many Column
 * @author Evan Byrne
 */
class BelongsTo extends Base {
	
	private $model;
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\Generate\IntColumn($column_name));
		
		// Model
		$model_class = (isset($options['model'])) ? $options['model'] : $column_name;
		$this->model = $model_class;
		
		// Get parent
		$this->set_method($column_name, function($model) use ($column_name, $model_class) {

			return call_user_func("\\Model\\$model_class::get", $model->$column_name);

		});
	
	}
	
}