<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\JsonResponse, Dingo\Shortcut as S;

class Main {

	public function index() {

		$s = new \Model\Base\Session();
		$secret = $s->set('Awesome secret session data');
		$res = $s->get($secret);
		$res->delete();
		return new JsonResponse($res);
	
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