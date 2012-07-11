<?php

/**
 * Root URL
 * @param Whether to include index.php/ in URL
 * @return The base URL
 */
function root_url() {

	return (!MOD_REWRITE) ? BASE_URL . 'index.php/' : BASE_URL;

}

/**
 * URL
 * @param Relative path to page
 * @param Full path to page
 */
function url($path = '') {

	return root_url() . $path;

}
	
/**
 * @param URL to redirect to
 */
function redirect($path = '') {
	
	header('Location: ' . root_url(true) . $url);
	exit;
	
}