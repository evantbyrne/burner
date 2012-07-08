<?php

namespace Column;

/**
 * Time Column
 * @author Evan Byrne
 */
class Time extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\TimeColumn($column_name, $options));
	
	}

}