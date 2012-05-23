<?php

namespace Model;

/**
 * Simple Model
 * @author Evan Byrne
 */
class Simple extends \Model\Base\Root {
	
	public static function blocks() {
	
		return array(
		
			new \Block\Text('headline'),
			new \Block\HasMany('articles', array('model'=>'Article', 'column'=>'simple'))
			
		);
	
	}
	
}