<?php

namespace Column;

/**
 * Point Column
 */
class Point extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\PointColumn($column_name, $options));
	
	}

}