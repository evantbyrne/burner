<?php

namespace Column;

/**
 * Boolean Column
 * @author Evan Byrne
 */
class Boolean extends TinyInt {
	
	/**
	 * @inheritdoc
	 */
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, array_merge(array(
			
			'template' => 'select',
			'choices'  => array(0 => 'False', 1 => 'True'),
			'valid'    => function($value) {
				
				return in_array($value, array(0, 1)) ? true : 'Invalid boolean.';
				
			}
			
		), $options));
	
	}
	
	/**
	 * @inheritdoc
	 */
	public function set($value) {
		
		return intval($value);
		
	}
	
}