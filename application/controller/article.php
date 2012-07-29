<?php

namespace Controller;

/**
 * Example Article Controller
 */
class Article extends Base {

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

	/**
	 * Add
	 */
	public function add() {

		if(is_post()) {

			$article = \Model\Article::from_post(array('title', 'content'));
			$errors = $article->valid();

			if(is_array($errors)) {

				$this->data($article->to_array());
				$this->data('errors', $errors);

			} else {

				$id = $article->save();
				redirect("article/$id");

			}

		}

	}

}