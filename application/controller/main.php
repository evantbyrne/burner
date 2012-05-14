<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {
		
		$article = \Page\Article::get(1);
		return new Response(($article) ? "Title: <em>{$article->title}</em>" : '<em>Article not found</em>');
	
	}
	
	public function foo() {
	
		return new Response("<form method='post'><input name='name' /></form>");
	
	}
	
	public function foo_action() {
	
		return new Response($_POST['name']);
	
	}
	
	public function bar() {
	
		print_r(func_get_args());
		return new Response();
	
	}

}