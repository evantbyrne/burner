<?php

namespace Model;

/**
 * Example Article Model
 * @option list = awesome, title, post_date
 */
class Article extends \Core\Model\Base {
	
	/**
	 * Title
	 * @option type = Varchar
	 * @option length = 125
	 * @option required = Title field is required.
	 * @option unique = Title must be unique.
	 */
	public $title;

	/**
	 * Post date
	 * @option type = Date
	 */
	public $post_date;

	/**
	 * Post time
	 * @option type = Time
	 */
	public $post_time;

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
	 * Tags
	 * @option type = ManyToMany
	 * @option model = Tag
	 * @option middleman = ArticleTag
	 */
	public $tags;

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