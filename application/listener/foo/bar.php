<?php

namespace Listener\Foo;

class Bar {
	
	public static $priority = 1;

	public function run($msg) {

		echo "$msg ";

	}

}