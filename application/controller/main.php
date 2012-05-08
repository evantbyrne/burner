<?php

namespace Controller;
use Dingo\Route, Dingo\Cookie, Dingo\View;

class Main {

	public function index() {
	
		echo View::render('hello');
	
	}
	
	public function foo() {
	
		echo 'Foooo!';
	
	}
	
	public function bar() {
	
		print_r(func_get_args());
	
	}

}