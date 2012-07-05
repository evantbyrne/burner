<?php

namespace Column;

/**
 * Int Column
 * @author Evan Byrne
 */
class Int extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\IntColumn($column_name, $options));
	
	}

}