<?php

namespace Controller;

/**
 * Example Article Controller
 */
class Article extends \Core\Controller\Base {

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
			
			if($this->valid($article)) {

				$id = $article->save();
				redirect("article/$id");

			}

		}

	}

	/**
	 * Edit
	 */
	public function edit($id) {

		$article = \Model\Article::id($id) or $this->error(404);

		if(is_post()) {

			$article->merge_post(array('title', 'content'));
			
			if($this->valid($article)) {

				$article->save();
				redirect("article/$id");

			}

		} else {

			$this->data($article->to_array());

		}

	}

}