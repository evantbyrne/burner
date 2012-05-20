<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {

		/*$user = new \Model\User();
		$user->id = 1;
		$user->type = \Model\Base\User::level('user');
		$user->set_email('evantbyrne@gmail.com');
		$user->set_password('password123');
		//var_dump($user->check());
		//return new Response("{$user->email}:{$user->password}");
		
		$a = new \Model\Article();
		//$a->set_owner($user);
		var_dump($a->can($user, 'read'));
		var_dump($a->can($user, 'create'));
		var_dump($a->can($user, 'update'));
		var_dump($a->can($user, 'delete'));*/
		
		$s = new \Model\Simple();
		$s->headline = 'Foo';
		$s->other = 'Bar';
		return new Response("headline:{$s->headline}\nother:{$s->other}");
	
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