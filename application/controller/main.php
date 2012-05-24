<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\JsonResponse, Dingo\Shortcut as S;

class Main {

	public function index() {

		$s = new \Model\Simple();
		$s->id = 123;
		$s->headline = 'Awesome Headline';
		print_r($s->update(false));
		return new Response();
	
	}
	
	public function foo() {
	
		return new Response("<form method='post'><input name='name' /></form>");
	
	}
	
	public function foo_action() {
	
		return new Response($_POST['name']);
	
	}
	
	public function bar() {
	
		return new JsonResponse(func_get_args());
	
	}

}