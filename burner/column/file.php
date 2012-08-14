<?php

namespace Column;
use Library\Input;

/**
 * File Column
 * @author Evan Byrne
 */
class File extends Varchar {
	
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
			'length'   => 255,
			'template' => 'file',
			'list'     => false
		
		), $options));
	
	}
	
	/**
	 * @inheritdoc
	 */
	public function finalize($value) {
		
		if(empty($value['tmp_name'])) {
			
			return null;
			
		}
			
		//mkdir($this->get_option('dir'), 0777, true);

		$e = explode('.', $value['name']);
		$end = array_pop($e);
		$name = random() . '.' . implode('.', $e) . '.' . $end;
		//die($name);
		move_uploaded_file($value['tmp_name'], $this->get_option('dir') . "/$name");

		return $name;
		
	}

}