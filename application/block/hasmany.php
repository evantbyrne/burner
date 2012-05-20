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
	
	}
	
	public function get($value) {
	
		return $value;
	
	}
	
	public function set($value) {
	
		return $value;
	
	}

}