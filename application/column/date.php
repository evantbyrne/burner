<?php

namespace Column;

/**
 * Date Column
 * @author Evan Byrne
 */
class Date extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\DateColumn($column_name, $options));
	
	}

}