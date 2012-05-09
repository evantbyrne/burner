<?php

namespace Dingo;

/**
 * Shortcut Class
 * @author Evan Byrne
 */
class Shortcut {

	/**
	 * Render Response
	 * @param View to load
	 * @param Associated array of data to pass to view
	 * @param HTTP status code
	 * @return HTTP Response object
	 */
	public static function render_response($view, $data = null, $code = null) {

		return new Response(View::render($view, $data), $code);

	}

}