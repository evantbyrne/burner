<?php

namespace Library\Template;

/**
 * Base Template Interface
 *
 * All template libraries must implement this interface.
 * @author Evan Byrne
 */
interface BaseInterface {
	
	/**
	 * Render
	 * @param string Template name
	 * @param array Associative array of data
	 * @return string Output
	 */
	public static function render($template, $data = array());

}