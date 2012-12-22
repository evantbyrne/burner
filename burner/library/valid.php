<?php

namespace Library;

/**
 * Validation Library
 * @author Evan Byrne
 */
class Valid {
	
	/**
	 * Username
	 * @param string Value to validate
	 * @return boolean
	 */
	public static function username($username) {
		
		return preg_match('/^([\-_ a-z0-9]+)$/is', $username);
		
	}
	
	/**
	 * Name
	 * @param string Value to validate
	 * @return boolean
	 */
	public static function name($name) {
		
		return preg_match('/^([ a-z]+)$/is', $name);
		
	}
	
	/**
	 * Number
	 * @param string Value to validate
	 * @return boolean
	 */
	public static function number($number) {
		
		return preg_match('/^([\.0-9]+)$/is', $number);
		
	}
	
	/**
	 * Int
	 * @param string Value to validate
	 * @return boolean
	 */
	public static function int($int) {
		
		return preg_match('/^([0-9]+)$/is', $int);
		
	}
	
	/**
	 * Range
	 * @param mixed Low end of range
	 * @param mixed High end of range
	 * @param mixed Value to validate
	 * @return boolean
	 */
	public static function range($low, $high, $number) {
		
		return ($low <= $number AND $high >= $number);
		
	}
	
	/**
	 * Length
	 * @param int Low end of range
	 * @param int High end of range
	 * @param int Value to validate
	 * @return boolean
	 */
	public static function length($low, $high, $number) {
		
		return self::range($low, $high, strlen($number));
		
	}
	
	/**
	 * Email
	 * @param string Value to validate
	 * @return boolean
	 */
	public static function email($email) {
		
		return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
	
	}
	
	/**
	 * Phone
	 * Validates the format of U.S. phone numbers
	 * @param string Value to validate
	 * @param boolean If true, then must be exactly 10 digits
	 * @return boolean
	 */
	public static function phone($phone, $strict=false) {
		
		if(!$strict) {
			
			$phone = preg_replace('/([ \(\)\-]+)/', '', $phone);
			
		}
		
		return preg_match('/^([0-9]{10})$/', $phone);
		
	}
	
}