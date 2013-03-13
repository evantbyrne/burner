<?php

namespace Core;

Route::add('App.Vendor.Admin.Controller.Admin', array(

	'GET:admin' => 'index',
	'GET:admin/:any' => 'model',
	'GET:admin/:any/:int/children/:any' => 'children',
	'BOTH:admin/:any/:int' => 'edit',
	'BOTH:admin/:any/:int/children/:any/edit/:int' => 'edit_child',
	'BOTH:admin/:any/add' => 'add',
	'BOTH:admin/:any/:int/children/:any/add' => 'add_child',
	'BOTH:admin/:any/delete/:int' => 'delete',
	'BOTH:admin/ajax/:any/add_modal' => 'ajax_add_modal',
	'GET:admin/ajax/:any/add_modal/:int' => 'ajax_add_modal_refresh',
	'POST:admin/ajax/order' => 'ajax_order'

));