<?php

namespace Library;

/**
 * Auth Library
 */
class Language {

	public static function get($prefix, $key) {

		$klass = to_php_namespace('App.Language.' . \Core\Config::get('language') . ".$prefix");
		return (!empty($klass::$$key)) ? $klass::$$key : null; 

	}

}