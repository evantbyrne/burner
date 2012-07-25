<?php

namespace Core;

Route::add(array(

	// Home
	'GET:/' => array('main', 'index'),
	
	// Blog
	'GET:blog'         => array('article', 'index'),
	'GET:article/:int' => array('article', 'view'),

	// Authentication
	'GET:auth/login'          => array('auth', 'login'),
	'POST:auth/login'         => array('auth', 'login'),
	'GET:auth/login/:any'     => array('auth', 'login'),
	'POST:auth/login/:any'    => array('auth', 'login'),
	'GET:auth/register'       => array('auth', 'register'),
	'POST:auth/register'      => array('auth', 'register'),
	'GET:auth/logout'         => array('auth', 'logout'),
	'GET:auth/verify/:any'    => array('auth', 'verify_action'),
	'GET:auth/reset_request'  => array('auth', 'reset_request'),
	'POST:auth/reset_request' => array('auth', 'reset_request_action'),
	'GET:auth/reset/:any'     => array('auth', 'reset'),
	'POST:auth/reset/:any'    => array('auth', 'reset_action'),

	// Admin
	'GET:admin'           => array('admin', 'index'),
	'GET:admin/:any'      => array('admin', 'model'),
	'GET:admin/:any/:int' => array('admin', 'row')
	
));