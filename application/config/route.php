<?php

namespace Dingo;

Route::add(array(

	'/'        => array('main', 'index'),
	'one/two'  => array('main', 'foo'),
	'int/:int' => array('main', 'bar')
	
));