<?php

namespace Block;

/**
 * Email Block
 * @author Evan Byrne
 */
class Email extends Text {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\Generate\TextColumn($column_name, $options));
		// TODO: Add special email validation
	
	}
	
}