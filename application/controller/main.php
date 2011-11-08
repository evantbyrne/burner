<?php

namespace Controller;
use Dingo\Route, Dingo\Cookie;

class Main {

	public function index() {
	
		echo 'Hello, World!';
		echo (Cookie::delete('dsfsdfs')) ? ' yep' : ' nope';
	
	}
	
	public function foo() {
	
		echo 'Foooo!';
	
	}
	
	public function bar() {
	
		print_r(func_get_args());
	
	}

}