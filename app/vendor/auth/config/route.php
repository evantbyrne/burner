<?php

namespace Core;

Route::add('App.Controller.Auth', array(

	'BOTH:auth/login' => 'login',
	'BOTH:auth/login/:any' => 'login',
	'BOTH:auth/register' => 'register',
	'GET:auth/logout' => 'logout',
	'GET:auth/verify/:any' => 'verify',
	'BOTH:auth/reset_request' => 'reset_request',
	'BOTH:auth/reset/:any' => 'reset'

));