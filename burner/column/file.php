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
			
			'length'   => 5,
			'blank'    => true,
			'template' => 'file',
			'list'     => false
		
		), $options));
	
	}
	
	/**
	 * @inheritdoc
	 */
	public function set($value) {
		
		if(!empty($value['tmp_name'])) {
			
			$e = explode('.', $value['name']);
			return end($e);
			
		}
		
		return null;
		
	}
	
	/**
	 * @inheritdoc
	 */
	public function finalize($model) {
		
		$name = $this->column_name();
		if(!empty($_FILES[$name]['tmp_name'])) {
			
			$value = $_FILES[$name];
			$e = explode('.', $value['name']);
			$end = array_pop($e);
			$file = $this->get_option('dir') . '/' . "{$model->id}.$end";
			move_uploaded_file($value['tmp_name'], $file);
			
		}
		
	}

}