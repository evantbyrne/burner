<?php

namespace Block;

/**
 * Example Text Block
 * @author Evan Byrne
 */
class Text extends Base {
	
	public function __construct($column, $options = array()) {
		
		parent::__construct();
		
		// Columns (Just one for most)
		$this->add(new \Mysql\Generate\TextColumn($column, $options));
		
		// Generate additional tables...
	
	}

}