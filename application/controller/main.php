<?php

namespace Controller;
use Dingo\DB, Dingo\Route, Dingo\Cookie, Dingo\View, Dingo\Response, Dingo\Shortcut as S;

class Main {

	public function index() {
	
		//$con = DB::connection();
		//$s = new \Mysql\Generate\Select('user');
		//print_r($con->fetch($s->build()));
		
		/*$p = new \Page\Base('article');
		$p->add(new \Block\Text('title'));
		$p->create_table();*/
		
		$p = new \Page\Article();
		$p->create_table();
		$p->drop_table();
		
		return new Response($p->table());
		
		//return S::render_response('hello');
	
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