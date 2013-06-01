<?php

namespace Core;

// Home
Route::add('App.Controller.Main', array(

	// Default route
	'GET:/' => 'index'

));

// Authentication
Route::vendor('auth');

// Admin
Route::vendor('admin');