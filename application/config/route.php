<?php

namespace Core;

Route::add(array(

	// Home
	'GET:/' => array('main', 'index'),
	
	// Blog
	'GET:blog'               => array('article', 'index'),
	'GET:article/:int'       => array('article', 'view'),
	'GET:article/add'        => array('article', 'add'),
	'POST:article/add'       => array('article', 'add'),
	'GET:article/edit/:int'  => array('article', 'edit'),
	'POST:article/edit/:int' => array('article', 'edit'),

	// Authentication
	'GET:auth/login'          => array('auth', 'login'),
	'POST:auth/login'         => array('auth', 'login'),
	'GET:auth/login/:any'     => array('auth', 'login'),
	'POST:auth/login/:any'    => array('auth', 'login'),
	'GET:auth/register'       => array('auth', 'register'),
	'POST:auth/register'      => array('auth', 'register'),
	'GET:auth/logout'         => array('auth', 'logout'),
	'GET:auth/verify/:any'    => array('auth', 'verify'),
	'GET:auth/reset_request'  => array('auth', 'reset_request'),
	'POST:auth/reset_request' => array('auth', 'reset_request'),
	'GET:auth/reset/:any'     => array('auth', 'reset'),
	'POST:auth/reset/:any'    => array('auth', 'reset'),

	// Admin
	'GET:admin' => array('admin', 'index'),
	'GET:admin/:any' => array('admin', 'model'),
	'GET:admin/:any/:int/children/:any' => array('admin', 'children'),
	'GET:admin/:any/:int' => array('admin', 'edit'),
	'POST:admin/:any/:int' => array('admin', 'edit'),
	'GET:admin/:any/:int/children/:any/edit/:int' => array('admin', 'edit_child'),
	'POST:admin/:any/:int/children/:any/edit/:int' => array('admin', 'edit_child'),
	'GET:admin/:any/add' => array('admin', 'add'),
	'POST:admin/:any/add' => array('admin', 'add'),
	'GET:admin/:any/:int/children/:any/add' => array('admin', 'add_child'),
	'POST:admin/:any/:int/children/:any/add' => array('admin', 'add_child'),
	'GET:admin/:any/delete/:int' => array('admin', 'delete'),
	'POST:admin/:any/delete/:int' => array('admin', 'delete')
	
));