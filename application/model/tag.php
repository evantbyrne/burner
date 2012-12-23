<?php

namespace Model;

/**
 * Example Tag Model
 */
class Tag extends \Core\Model\Base {
	
	/**
	 * Name
	 * @option type = Varchar
	 * @option length = 100
	 */
	public $name;

	/**
	 * Articles
	 * @option type = ManyToMany
	 * @option model = Article
	 * @option middleman = ArticleTag
	 */
	public $articles;

	/**
	 * To String
	 * @return string Name
	 */
	public function __toString() {

		return $this->name;

	}

}