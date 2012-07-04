<?php

namespace Model;

/**
 * Example Session Model
 * @author Evan Byrne
 */
class Session extends \Model\Base\Session {
	
	/**
	 * @inheritdoc
	 */
	public static function columns() {
	
		return array_merge(parent::columns(), array(
		
			new \Column\Text('stuff')
			
		));
	
	}
	
}