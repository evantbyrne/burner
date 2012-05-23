<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\JsonResponse, Dingo\Shortcut as S;

class Main {

	public function index() {

		$a = new \Model\Article();
		$a->simple = 1;
		return new JsonResponse($a->simple());
	
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