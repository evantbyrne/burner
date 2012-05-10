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
		$this->add('title', new \Block\Text(array('max_length'=>120)));
		$this->add('content', new \Block\Set\Text());
		
		// Comments
		$this->add('comments', new \Block\Set\Multi(array(
		
			'author' => new \Block\Text(array('max_length'=>120)),
			'content' => new \Block\Text()
		
		)));
	
	}

}