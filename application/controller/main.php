<?php

namespace Controller;
use Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response;//, Dingo\Shotcut\render_response;

class Main {

	public function index() {
	
		return new Response(View::render('hello'));
	
	}
	
	public function foo() {
	
		echo 'Foooo!';
	
	}
	
	public function bar() {
	
		print_r(func_get_args());
	
	}

}