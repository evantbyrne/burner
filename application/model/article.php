<?php

namespace Model;

/**
 * Example Article Model
 */
class Article extends \Core\Model\Base {
	
	/**
	 * Construct
	 */
	public function __construct() {

		$this->schema(
			new \Column\Varchar('title', array('length' => 125, 'required' => 'Title field is required.')),
			new \Column\Text('content', array('required' => 'Content field is required.')),
			new \Column\HasMany('comments', array('model' => 'Comment', 'column' => 'article'))
		);

		$this->admin('title');
		$this->admin('content', array('list' => false));
		$this->admin('comments');

	}

	/**
	 * To String
	 * @return string Title
	 */
	public function __toString() {

		return $this->title;

	}

}