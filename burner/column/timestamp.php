<?php

namespace Column;

/**
 * Timestamp Columnk
 * @author Evan Byrne
 */
class Timestamp extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\TimestampColumn($column_name, $options));
	
	}

}