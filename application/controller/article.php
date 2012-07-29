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
			$article->authors_add(3)->authors_add('foo');
			$article->save();

			var_dump($article->in_authors(1));
			var_dump($article->in_authors(2));
			var_dump($article->in_authors(3));
			var_dump($article->get_authors());
			exit;

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