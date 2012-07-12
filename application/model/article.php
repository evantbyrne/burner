<?php

namespace Model;

/**
 * Example Article Model
 */
class Article extends Base {
	
	/**
	 * Construct
	 */
	public function __construct() {

		$this->schema(
			new \Column\Varchar('title', array('length' => 125)),
			new \Column\Text('content'),
			new \Column\HasMany('comments', array('model' => 'Comment', 'column' => 'article'))
		);

		//$this->require('admin');
		//$this->admin('comments', array('paginate' => 10));

	}

}