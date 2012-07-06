<?php

namespace Model;

/**
 * Simple Model
 * @author Evan Byrne
 */
class Simple extends Base\Root {
	
	/**
	 * @inheritdoc
	 */
	public static function columns() {
	
		return array(
		
			new \Column\Text('headline'),
			new \Column\HasMany('articles', array('model'=>'Article', 'column'=>'simple'))
			
		);
	
	}
	
}