<?php

//namespace Controller;


class Main {

	public function index() {
	
		echo 'Hello, World!';
	
	}
	
	public function foo() {
	
		echo 'Foooo!';
	
	}
	
	public function bar() {
	
		print_r(func_get_args());
	
	}

}