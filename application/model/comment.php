<?php

namespace Model;

/**
 * Example Comment Model
 */
class Comment extends \Core\Model\Base {
	
	/**
	 * Construct
	 */
	public function __construct() {

		$this->schema(
			new \Column\BelongsTo('article', array('model' => 'Article')),
			new \Column\Text('content', array('required' => 'Content field is required.'))
		);
		
		$this->admin('article');
		$this->admin('content');
	
	}

}