<?php

namespace App\Model;

/**
 * Example Category Model
 */
class Category extends \Core\Model\Base {

	/**
	 * @option type = Varchar
	 * @option length = 125
	 * @option required = Title field is required.
	 */
	public $title;

	/**
	 * @option type = HasMany
	 * @option model = Article
	 * @option column = category
	 */
	public $articles;

	/**
	 * To String
	 * @return string Title
	 */
	public function __toString() {

		return $this->title;

	}

}