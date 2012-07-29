<?php

namespace Column;

/**
 * IntArray Column
 * @author Evan Byrne
 */
class IntArray extends Text {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options);
		
		// Add
		$this->set_method($column_name . '_add', function($model, $value) use ($column_name) {
		
			$data = isset($model->{$column_name}) ? json_decode($model->{$column_name}, true) : array();
			$data[] = intval($value);
			$model->{$column_name} = json_encode($data);
			return $model;
		
		});

		// In
		$this->set_method("in_$column_name", function($model, $value) use ($column_name) {
		
			return in_array(intval($value), json_decode($model->{$column_name}, true));
		
		});

		// Get
		$this->set_method("get_$column_name", function($model) use ($column_name) {
		
			return json_decode($model->{$column_name}, true);
		
		});
	
	}

}