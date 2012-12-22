<?php

namespace Model;

/**
 * Example User Model
 */
class User extends \Core\Model\User {
	
	/**
	 * Avatar
	 * @option type = Image
	 * @option required = Image field is required.
	 */
	public $avatar;

	/**
	 * Avatar Path
	 * @return string
	 */
	public function avatar_path() {

		if(!is_dir('static/user')) {

			mkdir('static/user', 0755, true);

		}

		return "static/user/{$this->id}";

	}
	
}