<?php

namespace Controller;
use Dingo\Route, Dingo\Response, Dingo\JsonResponse, Library\Input;

class Main {

	public function index() {
		
		return Response::view('hello');
	
	}
	
}