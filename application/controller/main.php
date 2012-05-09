<?php

namespace Controller;
use Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {
	
		return S::render_response('hello');
	
	}
	
	public function foo() {
	
		return new Response('Foooo!', 404);
	
	}
	
	public function bar() {
	
		print_r(func_get_args());
	
	}

}