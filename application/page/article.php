<?php

namespace Page;

/**
 * Example Article Page
 * @author Evan Byrne
 */
class Article extends Base {
	
	// Table name
	public static $table = 'article';
	
	// Blocks
	public static $blocks = array(
		
		new \Block\Text('title', array('max_length'=>120)),
		new \Block\Text('content')
		
	);

}