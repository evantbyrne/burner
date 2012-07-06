<?php

namespace Controller;
use Dingo\Route, Dingo\Response, Dingo\JsonResponse, Dingo\Shortcut as S, Library\Input;

class Main {

	public function index() {
		
		return new Response(\Language\Auth::email_success_message('http://localhost'));
	
	}
	
	public function foo() {
	
		return new Response("<form method='post'><input name='name' /></form>\n<form method='post'><input type='submit' value='submit nothing' /></form>");
	
	}
	
	public function foo_action() {
	
		return new Response(\Library\Input::post('name', '<em>No Name Given</em>'));
	
	}
	
	public function bar() {
	
		return new JsonResponse(func_get_args());
	
	}

}