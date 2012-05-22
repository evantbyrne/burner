<?php

namespace Block;

/**
 * Has Many Block
 * @author Evan Byrne
 */
class HasMany extends Base {
	
	private $model;
	private $column;
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\Generate\IntColumn($column_name, $options));
		
		// Model
		$this->model = (isset($options['model'])) ? $options['model'] : $column_name;
		
		// Column
		if(!isset($options['column'])) {
		
			throw new \Exception("Option 'column' must be set for $column_name column.");
		
		}
		
		$this->column = $options['column'];
		
		// Get
		$this->set_method("get_$column_name", function($model) use ($column_name) {
		
			return (isset($model->$column_name)) ? $model->$column_name : null;
		
		});
		
		// Set
		$this->set_method("set_$column_name", function($model, $value) use ($column_name) {
		
			$model->$column_name = $value;
		
		});
	
	}

}