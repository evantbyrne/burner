<?php

namespace Column;

/**
 * Date Column
 * @author Evan Byrne
 */
class Date extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		$options = array_merge(array('template' => 'date'), $options);
		parent::__construct($column_name, $options, new \Mysql\DateColumn($column_name, $options));
	
	}

}