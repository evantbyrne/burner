<?php

namespace Controller;
use Dingo\Route, Dingo\Response, Dingo\JsonResponse, Dingo\Shortcut as S, Library\Input;

class Main {

	public function index() {

		//$data = '<disallowed>Booo!</disallowed>This is <i>Awesome</i>!';
		//return new Response(\Library\Xss::clean($data));
		
		//$s = new \Model\Simple();
		//$s->headline = 'Wooo!';
		//$id = $s->insert();
		/*$query = new \Model\Query\Insert('simple');
		$query->value('headline', 'Awesome!');
		$id = $query->execute();
		return new Response($id);*/
		
		$col = new \Mysql\Generate\TimestampColumn('foo', array('auto_update' => true));
		
		return new Response($col->build());
	
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