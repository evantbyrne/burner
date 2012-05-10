<?php

namespace Block;

/**
 * Example Text Block
 * @author Evan Byrne
 */
class Text extends Base {
	
	public function __construct($column, $options = array()) {
		
		// Set the column name
		parent::__construct($column);
		
		// Columns (Just one for most)
		$this->add(new Mysql\Generate\TextColumn($column, $options));
		
		// Generate additional tables...
	
	}

}