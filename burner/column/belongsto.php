<?php

namespace Column;

/**
 * Has Many Column
 * @author Evan Byrne
 */
class BelongsTo extends Base {
	
	private $model;
	
	public function __construct($column_name, $options = array()) {
		
		$column_options = (isset($options['null'])) ? array('null' => $options['null']) : array();
		
		parent::__construct($column_name, $options, new \Mysql\IntColumn($column_name, $column_options));
		
		// Get parent
		$this->set_method($column_name, function($model) use ($column_name) {

			return call_user_func("\\Model\\$column_name::id", $model->$column_name);

		});
	
	}
	
}