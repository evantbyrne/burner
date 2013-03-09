<?php

namespace Core;

// Home
Route::add('App.Controller.Main', array(

	'GET:/' => 'index'

));

// Blog
Route::add('App.Controller.Article', array(

	'GET:blog' => 'index',
	'GET:article/:int' => 'view',
	'BOTH:article/add' => 'add',
	'BOTH:article/edit/:int' => 'edit'

));

// Authentication
Route::add('App.Controller.Auth', array(

	'BOTH:auth/login' => 'login',
	'BOTH:auth/login/:any' => 'login',
	'BOTH:auth/register' => 'register',
	'GET:auth/logout' => 'logout',
	'GET:auth/verify/:any' => 'verify',
	'BOTH:auth/reset_request' => 'reset_request',
	'BOTH:auth/reset/:any' => 'reset'

));

// Admin
Route::add('App.Controller.Admin', array(

	'GET:admin' => 'index',
	'GET:admin/:any' => 'model',
	'GET:admin/:any/:int/children/:any' => 'children',
	'BOTH:admin/:any/:int' => 'edit',
	'BOTH:admin/:any/:int/children/:any/edit/:int' => 'edit_child',
	'BOTH:admin/:any/add' => 'add',
	'BOTH:admin/:any/:int/children/:any/add' => 'add_child',
	'BOTH:admin/:any/delete/:int' => 'delete',
	'BOTH:admin/ajax/:any/add_modal' => 'ajax_add_modal',
	'GET:admin/ajax/:any/add_modal/:int' => 'ajax_add_modal_refresh'

));