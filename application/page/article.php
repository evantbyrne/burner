<?php

namespace Page;

/**
 * Example Article Page
 * @author Evan Byrne
 */
class Article extends Base {
	
	/**
	 * Blocks
	 * @return Array of blocks that make up page
	 */
	public static function blocks() {
	
		return array(
		
			new \Block\Text('title', array('max_length'=>120)),
			new \Block\Text('content')
		
		);
		
	}

}