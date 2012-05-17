<?php

namespace Dingo;

/**
 * CLI Class
 */
class CLI {
	
	/**
	 * Run
	 */
	public static function run() {
		
		$options = getopt('', array('create:', 'drop:'));
		
		foreach($options as $name => $value) {
			
			if($name == 'drop') self::drop($value);
			elseif($name == 'create') self::create($value);
			
		}
		
	}
	
	/**
	 * Create
	 * @param Model to create table. Name of class (case-sensitive, don't include namespace)
	 */
	public static function create($model) {
		
		if(is_array($model)) {
			
			foreach($model as $m) {
				
				self::create($m);
				
			}
			
		} else {
		
			$model_class = "\\Model\\$model";
			$model_class::create_table();
			
		}
		
	}
	
	/**
	 * Drop
	 * @param Model to drop table. Name of class (case-sensitive, don't include namespace)
	 */
	public static function drop($model) {
		
		if(is_array($model)) {
			
			foreach($model as $m) {
				
				self::drop($m);
				
			}
			
		} else {
		
			$model_class = "\\Model\\$model";
			$model_class::drop_table();
		
		}
		
	}
	
}