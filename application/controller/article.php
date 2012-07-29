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

			$article->title = 'Awesome Article';
			$article->content = 'Even more awesome article content.';
			$article->set_json(array(1 => 'one', 'two' => 'foo', 'three' => array(1.1, 2.2, 3.3)));
			$article->save();

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

		$article = \Model\Article::id($id) or $this->error(404);
		$this->data('article', $article);

	}

}