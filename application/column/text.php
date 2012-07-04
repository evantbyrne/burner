<?php

namespace Column;

/**
 * Text Column
 * @author Evan Byrne
 */
class Text extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options, new \Mysql\Generate\TextColumn($column_name, $options));
	
	}

}