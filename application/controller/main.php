<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {
	
		//$con = DB::connection();
		//$s = new \Mysql\Generate\Select('user');
		//print_r($con->fetch($s->build()));
		
		//$p = new \Page\Article();
		//$p->create_table();
		//$p->drop_table();
		
		$article = \Page\Article::get(1);
		return new Response(($article) ? $article->title : '<em>Article not found</em>');
		
		//return S::render_response('hello');
	
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