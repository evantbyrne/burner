<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {
		
		$user = \Model\User::get(1);
		$user->type = \Model\Base\User::level('user');
		
		if($user !== false) {
		
			$a = new \Model\Article();
			print_r($user);
			print_r($a);
			var_dump($a->can($user, 'read'));
			var_dump($a->can($user, 'create'));
			var_dump($a->can($user, 'update'));
			var_dump($a->can($user, 'delete'));
			return new Response();
		
		} else {
			
			return new Response('<em>User not found</em>');
			
		}
	
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