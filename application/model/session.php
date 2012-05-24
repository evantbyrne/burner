<?php

namespace Model;

/**
 * Example Session Model
 * @author Evan Byrne
 */
class Session extends \Model\Base\Session {
	
	public static function blocks() {
	
		return array_merge(parent::blocks(), array(
		
			new \Block\Text('stuff')
			
		));
	
	}
	
}