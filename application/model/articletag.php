<?php

namespace Model;

/**
 * Example Article Tag Model
 */
class ArticleTag extends \Core\Model\Base {
	
	/**
	 * @inheritdoc
	 */
	public static $verbose = 'Article Tag';

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