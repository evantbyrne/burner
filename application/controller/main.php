<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {
		
		/*$article = \Page\Article::get(1);
		return new Response(($article) ? "Title: <em>{$article->title}</em>" : '<em>Article not found</em>');
		
		$p = new \Page\Article();
		$p->title = 'Yes';
		$p->content = 'Sweet content, bro.';
		var_dump($p->valid());*/
		
		//\Page\User::create_table();
		$user = new \Page\User();
		$user->set_email('evantbyrne@gmail.com');
		$user->set_password('password123');
		var_dump($user->check());
		return new Response("{$user->email}:{$user->password}");
	
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