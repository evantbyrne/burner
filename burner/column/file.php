<?php

namespace Column;
use Library\Input;

/**
 * File Column
 * @author Evan Byrne
 */
class File extends Char {
	
	/**
	 * @inheritdoc
	 */
	public function __construct($column_name, $options = array()) {
		
		// Column
		if(!isset($options['dir'])) {
		
			throw new \Exception("Option 'dir' must be set for $column_name column.");
		
		}
		
		parent::__construct($column_name, array_merge(array(
			
			'blank'    => true,
			'length'   => 30,
			'template' => 'file',
			'list'     => false
		
		), $options));
	
	}
	
	/**
	 * @inheritdoc
	 */
	public function set($value) {
		
		if(empty($value['tmp_name'])) {
			
			echo 'Empty';
			
		} else {
			
			print_r($value);
			
		}
		//var_dump($this->get_option('dir') . '/' . random());
		exit;
		
	}

}