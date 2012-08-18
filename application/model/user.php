<?php

namespace Model;

/**
 * Example User Model
 */
class User extends \Core\Model\User {
	
	/**
	 * @inheritdoc
	 */
	public function __construct() {
		
		parent::__construct();
		
		$this->schema(new \Column\Image('avatar', array(
				
			'required' => 'Banner field is required.',
			'path' => function($model) {

				if(!is_dir('static/user')) {

					mkdir('static/user', 0755, true);

				}

				return "static/user/{$model->id}";

			}

		)));
		
	}
	
}