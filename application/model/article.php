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
			new \Column\Varchar('title', array('length' => 125)),
			new \Column\Text('content'),
			new \Column\HasMany('comments', array('model' => 'Comment', 'column' => 'article'))
		);

		//$this->permission('admin');
		$this->admin('title');
		$this->admin('content', array('list' => false));
		//$this->admin('comments', array('paginate' => 10));

	}

}