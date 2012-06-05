<?php

namespace Block;

/**
 * Email Block
 * @author Evan Byrne
 */
class Email extends Varchar {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options);
		// TODO: Add special email validation
	
	}
	
}