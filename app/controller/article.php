<?php

namespace App\Controller;

/**
 * Example Article Controller
 */
class Article extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {

		$this->data('articles', \App\Model\Article::select()->order_desc('id')->fetch());

	}

	/**
	 * View
	 */
	public function view($id) {

		$article = \App\Model\Article::id($id) or $this->error(404);
		$this->data('article', $article);
		$this->data('comments', $article->comments()->select()->fetch());

	}

	/**
	 * Add
	 */
	public function add() {

		if(is_post()) {

			$article = \App\Model\Article::from_post(array('title', 'content'));
			
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

		$article = \App\Model\Article::id($id) or $this->error(404);

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