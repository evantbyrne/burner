<?php

namespace Core;

Route::add(array(

	// Home
	'GET:/' => array('main', 'index'),
	
	// Blog
	'GET:blog'               => array('article', 'index'),
	'GET:article/:int'       => array('article', 'view'),
	'BOTH:article/add'       => array('article', 'add'),
	'BOTH:article/edit/:int' => array('article', 'edit'),

	// Authentication
	'BOTH:auth/login'         => array('auth', 'login'),
	'BOTH:auth/login/:any'    => array('auth', 'login'),
	'BOTH:auth/register'      => array('auth', 'register'),
	'GET:auth/logout'         => array('auth', 'logout'),
	'GET:auth/verify/:any'    => array('auth', 'verify'),
	'BOTH:auth/reset_request' => array('auth', 'reset_request'),
	'BOTH:auth/reset/:any'    => array('auth', 'reset'),

	// Admin
	'GET:admin' => array('admin', 'index'),
	'GET:admin/:any' => array('admin', 'model'),
	'GET:admin/:any/:int/children/:any' => array('admin', 'children'),
	'BOTH:admin/:any/:int' => array('admin', 'edit'),
	'BOTH:admin/:any/:int/children/:any/edit/:int' => array('admin', 'edit_child'),
	'BOTH:admin/:any/add' => array('admin', 'add'),
	'BOTH:admin/:any/:int/children/:any/add' => array('admin', 'add_child'),
	'BOTH:admin/:any/delete/:int' => array('admin', 'delete')
	
));