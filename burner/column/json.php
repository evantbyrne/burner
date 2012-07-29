<?php

namespace Column;

/**
 * Json Column
 * @author Evan Byrne
 */
class Json extends Text {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options);
		
		// Set
		$this->set_method("set_$column_name", function($model, $value) use ($column_name) {
		
			$model->{$column_name} = json_encode($value);
			return $this;
		
		});

		// Get
		$this->set_method("get_$column_name", function($model) use ($column_name) {
		
			return json_decode($model->{$column_name}, true);
		
		});
	
	}

}