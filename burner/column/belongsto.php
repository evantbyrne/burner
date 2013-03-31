<?php

namespace Column;

/**
 * Has Many Column
 * @author Evan Byrne
 */
class BelongsTo extends Base {
	
	private $model;
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\IntColumn($column_name, $options));
		
		// Get parent
		$this->set_method($column_name, function($model) use ($column_name) {

			return call_user_func("\\App\\Model\\$column_name::id", $model->$column_name);

		});
	
	}
	
}