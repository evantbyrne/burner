<?php

namespace Page;

/**
 * Example Article Page
 * @author Evan Byrne
 */
class Article extends Base {
	
	public function __construct() {

		// Explicitly define table name
		parent::__construct('article');
		
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