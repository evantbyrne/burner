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
		
			// Title
			new \Block\Text('title', array('max_length'=>120, 'valid'=>function($value) {
			
				return preg_match('/^([a-zA-Z0-9\-\._ ]+)$/', $value) ? true : 'Invalid title. Must be alpha-numeric.';
			
			})),
			
			// Content
			new \Block\Text('content')
		
		);
		
	}

}