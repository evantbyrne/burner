<?php

namespace Core;

Config::set('admin', array(
	
	'user' => array(
		'email' => array('link' => true)
	),
	
	'usersession' => array(
		'secret' => array('link' => true),
		'expire' => array('link' => false)
	)
	
));