<?php

namespace Model;

/**
 * Example Article Model
 */
class Article extends \Core\Model\Base {
	
	/**
	 * Title
	 * @option type = Varchar
	 * @option length = 125
	 * @option required = Title field is required.
	 */
	public $title;

	/**
	 * Content
	 * @option type = Text
	 * @option required = Content field is required.
	 */
	public $content;

	/**
	 * Awesome
	 * @option type = Boolean
	 */
	public $awesome;

	/**
	 * Comments
	 * @option type = HasMany
	 * @option model = Comment
	 * @option column = article
	 */
	public $comments;

	/**
	 * To String
	 * @return string Title
	 */
	public function __toString() {

		return $this->title;

	}

}