<?php

namespace Column;

/**
 * Password Column
 * @author Evan Byrne
 */
class Password extends Char {
	
	/**
	 * @inheritdoc
	 */
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, array_merge(array('length' => 128, 'blank' => true, 'template' => 'password', 'admin_list' => false), $options));
	
	}

	/**
	 * Set
	 * @param mixed Input
	 * @return mixed Hashed value, or null on empty() input
	 */
	public function set($value) {

		return (empty($value)) ? null : \Library\Auth::hash($value);

	}
	
}