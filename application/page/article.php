<?php

namespace Page;

/**
 * Example Article Page
 * @author Evan Byrne
 */
class Article extends Base {
	
	// Table name
	public static $table = 'article';
	
	public function __construct() {
		
		// Article
		$this->add(new \Block\Text('title', array('max_length'=>120)));
		$this->add(new \Block\Text('content'));
		
		// Comments
		/*$this->add(new \Block\Set\Multi('comments', array(
		
			new \Block\Text('author', array('max_length'=>120)),
			new \Block\Text('content')
		
		)));*/
	
	}

}