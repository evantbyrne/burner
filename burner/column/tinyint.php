<?php

namespace Column;

/**
 * Tiny Int Column
 * @author Evan Byrne
 */
class TinyInt extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\TinyIntColumn($column_name, $options));
	
	}

}