<?php

namespace Library;

class String {

	/**
	 * Convert
	 * @param string String of unknown encoding
	 * @return string String of configured encoding
	 */
	public static function convert($string) {
		return mb_convert_encoding($string, mb_internal_encoding());
	}
	
	/**
	 * Length
	 * @param string String of unknown encoding
	 * @return int Length of string
	 */
	public static function length($string) {
		return mb_strlen(self::convert($string));
	}

	/**
	 * Truncate
	 * @param string String of unknown encoding
	 * @param int Max length
	 * @return int String of configured encoding
	 */
	public static function truncate($string, $length) {
		$string = self::convert($string);
		if(self::length($string) > $length) {
			return mb_substr($string, 0, $length);
		}

		return $string;
	}

}