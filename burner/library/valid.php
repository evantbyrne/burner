<?php

namespace Library;

/**
 * Validation Library
 * @author Evan Byrne
 */
class Valid {
	
	/**
	 * Username
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function username($username) {
		
		return preg_match('/^([\-_ a-z0-9]+)$/is', $username);
		
	}
	
	/**
	 * Name
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function name($name) {
		
		return preg_match('/^([ a-z]+)$/is', $name);
		
	}
	
	/**
	 * Number
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function number($number) {
		
		return preg_match('/^([\.0-9]+)$/is', $number);
		
	}
	
	/**
	 * Int
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function int($int) {
		
		return preg_match('/^([0-9]+)$/is', $int);
		
	}
	
	/**
	 * Range
	 * @param Low end of range
	 * @param High end of range
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function range($low, $high, $number) {
		
		return ($low <= $number AND $high >= $number);
		
	}
	
	/**
	 * Length
	 * @param Low end of range
	 * @param High end of range
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function length($low, $high, $number) {
		
		return self::range($low, $high, strlen($number));
		
	}
	
	/**
	 * Email
	 * @param Value to validate
	 * @return Boolean
	 */
	public static function email($email) {
		
		return preg_match('/^([_\.a-z0-9]{3,})@([\-_\.a-z0-9]{3,})\.([a-z]{2,})$/is',$email);
	
	}
	
	/**
	 * Phone
	 * Validates the format of a phone number located in the USA
	 * @param Value to validate
	 * @param If true, then must be exactly 10 digits
	 * @return Boolean
	 */
	public static function phone($phone, $strict=false) {
		
		if(!$strict) {
			
			$phone = preg_replace('/([ \(\)\-]+)/', '', $phone);
			
		}
		
		return preg_match('/^([0-9]{10})$/', $phone);
		
	}
	
}