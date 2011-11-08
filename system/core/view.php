<?php

namespace Dingo;
use Dingo\Load;

/**
 * Dingo Framework View Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2011
 * @Project Page    http://www.dingoframework.com
 */

class View {
	
	private static $extensions = array();
	private static $sections = array();
	private static $current_section = false;
	
	
	// Render
	// ---------------------------------------------------------------------------
	public static function render($view, $data=array()) {
		
		Load::view($view, $data);
		
		// Load extensions
		foreach(self::$extensions as $e) {
		
			print_r($e);
		
		}
		
		print_r(self::$sections);
	
	}
	
	
	// Extend
	// ---------------------------------------------------------------------------
	public static function extend($view, $data=array()) {
	
		self::$extensions[] = array('view'=>$view, 'data'=>$data);
	
	}
	
	
	// Section
	// ---------------------------------------------------------------------------
	public static function section($name) {
	
		self::$current_section = $name;
		ob_end_flush();
		ob_start();
	
	}
	
	
	// End Section
	// ---------------------------------------------------------------------------
	public static function end_section() {
	
		$data = ob_end_clean();
		self::$sections[self::$current_section] = $data;
		self::$current_section = false;
		ob_start();
	
	}
	
	
	// New Section
	// ---------------------------------------------------------------------------
	public static function new_section($name) {
	
		
	
	}
	
}