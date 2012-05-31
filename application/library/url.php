<?php

namespace Library;

/**
 * URL Library
 * @author Evan Byrne
 */
class Url {
	
	/**
	 * @param Whether to include index.php/ in URL
	 * @return The base URL
	 */
	public static function base($show_index = false) {
		
		return ($show_index AND !MOD_REWRITE) ? BASE_URL . 'index.php/' : BASE_URL;
		
	}
	
	/**
	 * @param Relative path to page
	 * @param Full path to page
	 */
	public static function page($path = false) {
		
		return url::base((MOD_REWRITE) ? true : false) . $path;
		
	}
	
	/**
	 * @param URL to redirect to
	 */
	public static function redirect($url = '') {
		
		header('Location: '.url::base(TRUE).$url);
		exit;
		
	}
	
}