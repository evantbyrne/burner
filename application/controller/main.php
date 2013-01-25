<?php

namespace Controller;

class Main extends \Core\Controller\Base {

	/**
	 * Index
	 */
	public function index() {
	
		$res = \Model\Article::select()->order_desc('id')->page(2, 3)->fetch();
		foreach($res as $article) {

			echo "{$article->title}\n";

		}

		exit;
	
	}
	
}