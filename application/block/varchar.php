<?php

namespace Block;

/**
 * Varchar Block
 * @author Evan Byrne
 */
class Varchar extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\Generate\VarcharColumn($column_name, $options));
	
	}

}