<?php

namespace Column;

/**
 * Password Column
 * @author Evan Byrne
 */
class Password extends Char {
	
	public function __construct($column_name, $options = array()) {
		
		/*if(!isset($options['valid'])) {
		
			$options['valid'] = function($value) {
			
				return \Library\Valid::email($value) ? true : 'Invalid email address.';
			
			};
		
		}*/
		
		parent::__construct($column_name, array_merge(array('blank' => true, 'template' => 'password', 'list' => false), $options));
	
	}
	
}