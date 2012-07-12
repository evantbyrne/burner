<?php

namespace Controller;

/**
 * Example Article Controller
 */
class Article extends Base {
	
	/**
	 * Constructor
	 * For testing
	 */
	public function __construct() {

		$article = new \Model\Article();
		$article->create_table(true);

		if(\Model\Article::id(1) === null) {

			\Model\Article::insert()
				->value('title', 'Awesome Article')
				->value('content', 'Even more awesome article content.')
				->execute();

		}

	}

	/**
	 * Index
	 */
	public function index() {

		$this->data('articles', \Model\Article::select()->order_desc('id')->fetch());

	}

	/**
	 * View
	 */
	public function view($id) {

		$this->data('article', \Model\Article::id($id));

	}

}