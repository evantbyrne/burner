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
		
		if(isset($options['create'])) self::create($options['create']);
		if(isset($options['drop'])) self::drop($options['drop']);
		
	}
	
	/**
	 * Create
	 * @param Model to create table. Name of class (case-sensitive, don't include namespace)
	 */
	public static function create($model) {
		
		$model_class = "\\Model\\$model";
		$model_class::create_table();
		
	}
	
	/**
	 * Drop
	 * @param Model to drop table. Name of class (case-sensitive, don't include namespace)
	 */
	public static function drop($model) {
		
		$model_class = "\\Model\\$model";
		$model_class::drop_table();
		
	}
	
}