<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {

		$a = new \Model\Article();
		$a->simple = 1;
		print_r($a->simple());
		return new Response();
	
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