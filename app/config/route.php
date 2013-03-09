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
Route::vendor('auth');

// Admin
Route::vendor('admin');