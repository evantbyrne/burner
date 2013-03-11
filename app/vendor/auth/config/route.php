<?php

namespace Core;

Route::add('App.Vendor.Auth.Controller.Auth', array(

	'BOTH:auth/login' => 'login',
	'BOTH:auth/login/:any' => 'login',
	'GET:auth/logout' => 'logout'

));