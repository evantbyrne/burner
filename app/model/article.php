<?php

namespace App\Model;

/**
 * Example Article Model
 * @option admin_list = order, title, post_date, awesome
 * @option admin_order = order
 * @option admin_page_size = false
 */
class Article extends \Core\Model\Base {
	
	/**
	 * @option type = Order
	 */
	public $order;

	/**
	 * @option type = BelongsTo
	 * @option required = Category field is required.
	 */
	public $category;

	/**
	 * @option type = BelongsTo
	 * @option required = User field is required.
	 */
	public $user;

	/**
	 * @option type = Varchar
	 * @option length = 125
	 * @option required = Title field is required.
	 * @option unique = Title must be unique.
	 */
	public $title;

	/**
	 * @option type = Date
	 */
	public $post_date;

	/**
	 * @option type = Time
	 */
	public $post_time;

	/**
	 * @option type = Text
	 * @option required = Content field is required.
	 */
	public $content;

	/**
	 * @option type = Boolean
	 */
	public $awesome;

	/**
	 * To String
	 * @return string Title
	 */
	public function __toString() {

		return $this->title;

	}

}