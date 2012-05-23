<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {

		//\Model\Simple::create_table();
		$s = new \Model\Simple();
		$s->headline = 'Baz';
		$res = $s->select();
		$res[0]->articles = 654321;
		print_r($res[0]->update());
		return new Response();
		
		//var_dump($s->get_articles());
		//return new Response("headline:{$s->headline}\nother:{$s->other}");
	
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