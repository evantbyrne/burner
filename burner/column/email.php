<?php

namespace Column;

/**
 * Email Column
 * @author Evan Byrne
 */
class Email extends Varchar {
	
	public function __construct($column_name, $options = array()) {
		
		if(!isset($options['valid'])) {
		
			$options['valid'] = function($value) {
			
				return \Library\Valid::email($value) ? true : 'Invalid email address.';
			
			};
		
		}
		
		parent::__construct($column_name, $options);
	
	}
	
}