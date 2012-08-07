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
 * @param string Relative path to page
 * @return string Full path to page
 */
function url($path = '') {

	return root_url() . $path;

}
	
/**
 * Redirect
 * @param string URL to redirect to
 */
function redirect($path = '') {
	
	header('Location: ' . root_url(true) . $path);
	exit;
	
}

/**
 * Login Redirect
 * @param string URL to redirect to after logging in
 */
function login_redirect($path = '') {
	
	redirect('auth/login/' . base64_encode($path));
	
}

/**
 * Is Get
 * @return boolean
 */
function is_get() {
	
	return ($_SERVER['REQUEST_METHOD'] == 'GET');
	
}

/**
 * Is Post
 * @return boolean
 */
function is_post() {
	
	return ($_SERVER['REQUEST_METHOD'] == 'POST');
	
}

/**
 * Escape
 */
function e($value) {

	echo htmlentities($value);

}