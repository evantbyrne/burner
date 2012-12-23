<?php

namespace Model;

/**
 * Example Article Tag Model
 */
class ArticleTag extends \Core\Model\Base {
	
	/**
	 * Article
	 * @option type = BelongsTo
	 */
	public $article;

	/**
	 * Tag
	 * @option type = BelongsTo
	 */
	public $tag;

}