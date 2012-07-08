<?php

namespace Column;

/**
 * Decimal Column
 * @author Evan Byrne
 */
class Decimal extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\DecimalColumn($column_name, $options));
	
	}

}