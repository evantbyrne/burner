<?php

namespace Column;

/**
 * Char Column
 * @author Evan Byrne
 */
class Char extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\Generate\CharColumn($column_name, $options));
	
	}

}