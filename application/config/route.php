<?php

Route::add(array(

	'/'=>'main.index',
	'one/two'=>'main.foo',
	'two/:int/four/:int'=>'main.bar'

));
