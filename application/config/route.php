<?php

namespace Dingo;

Route::add(array(

	// Home
	'GET:/' => array('main', 'index'),
	
	// Authentication
	'GET:auth/login'          => array('auth', 'login'),
	'POST:auth/login'         => array('auth', 'login_action'),
	'GET:auth/register'       => array('auth', 'register'),
	'POST:auth/register'      => array('auth', 'register_action'),
	'GET:auth/logout'         => array('auth', 'logout_action'),
	'GET:auth/verify/:any'    => array('auth', 'verify_action'),
	'GET:auth/reset_request'  => array('auth', 'reset_request'),
	'POST:auth/reset_request' => array('auth', 'reset_request_action'),
	'GET:auth/reset/:any'     => array('auth', 'reset'),
	'POST:auth/reset/:any'    => array('auth', 'reset_action'),

	// Admin
	'GET:admin' => array('admin', 'index')
	
));