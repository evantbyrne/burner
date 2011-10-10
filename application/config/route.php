<?php

Route::add(array(

	'/'=>'main.index',
	'one/two'=>'main.foo',
	'two/three/four/:int'=>'main.bar'

));
