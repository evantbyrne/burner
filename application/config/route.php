<?php

namespace Dingo;

Route::add(array(

	'GET:/'        => array('main', 'index'),
	'GET:one/two'  => array('main', 'foo'),
	'POST:one/two' => array('main', 'foo_action'),
	'GET:int/:int' => array('main', 'bar')
	
));