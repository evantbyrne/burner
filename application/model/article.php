<?php

namespace Model;

/**
 * Example Article Model
 * @author Evan Byrne
 */
class Article extends Base\ACL {
	
	/**
	 * Blocks
	 * @return Array of blocks that make up model
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
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		parent::__construct();
		
		$this->restrict('read', \Model\Base\User::level('any'));
		$this->restrict('create', \Model\Base\User::level('user'));
		$this->restrict('update', \Model\Base\User::level('admin'));
		$this->restrict('delete', \Model\Base\User::level('admin'));
		
		$this->allow_owner('update');
		$this->allow_owner('delete');
		
	}

}