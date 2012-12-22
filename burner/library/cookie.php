<?php

namespace Library;

/**
 * Cookie Library
 * @author Evan Byrne
 */
class Cookie {
	
	/**
	 * Set
	 * @param array Associated array of settings
	 * @return boolean Result from setcookie()
	 */
	public static function set($settings) {

		if(!isset($settings['path'])) $settings['path'] = '/';
		if(!isset($settings['domain'])) $settings['domain'] = FALSE;
		if(!isset($settings['secure'])) $settings['secure'] = FALSE;
		if(!isset($settings['httponly'])) $settings['httponly'] = FALSE;
		
		if(!isset($settings['expire'])) {
			
			$ex = new \DateTime();
			$time = $ex->format('U');
			
		} else {
			
			$ex = new \DateTime();
			$ex->modify($settings['expire']);
			$time = $ex->format('U');
			
		}
		
		return setcookie(
			
			$settings['name'],
			$settings['value'],
			$time,
			$settings['path'],
			$settings['domain'],
			$settings['secure'],
			$settings['httponly']
		
		);

	}
	
	/**
	 * Delete
	 * @param array Associated array of settings
	 * @return boolean Result from setcookie()
	 */
	public static function delete($settings) {
		
		if(!isset($settings['path'])) $settings['path'] = '/';
		if(!isset($settings['domain'])) $settings['domain'] = FALSE;
		if(!isset($settings['secure'])) $settings['secure'] = FALSE;
		if(!isset($settings['httponly'])) $settings['httponly'] = FALSE;
		
		if(is_array($settings)) {
			
			// If given array of settings
			return setcookie(
				
				$settings['name'],
				'',
				time() - 3600,
				$settings['path'],
				$settings['domain'],
				$settings['secure'],
				$settings['httponly']
				
			);
		
		} else {
			
			// Else, just the cookie name was given
			return setcookie($settings, '', time()-3600);
		
		}
	
	}

}