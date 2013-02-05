<?php

namespace Model;

/**
 * Example Comment Model
 */
class Comment extends \Core\Model\Base {
	
	/**
	 * User
	 * @option type = BelongsTo
	 */
	public $user;

	/**
	 * Article
	 * @option type = BelongsTo
	 */
	public $article;

	/**
	 * Content
	 * @option type = Text
	 * @option required = Content field is required.
	 */
	public $content;

}