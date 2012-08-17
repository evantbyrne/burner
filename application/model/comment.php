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
			new \Column\BelongsTo('user', array('default' => function() {
				
				return \Controller\Auth::user()->id;
				
			})),
			
			new \Column\BelongsTo('article'),
			new \Column\Text('content', array('required' => 'Content field is required.'))
		);
		
		$this->admin('user');
		$this->admin('article');
		$this->admin('content');
	
	}

}