<?php

namespace Core;

/**
 * Database Class
 * @author Evan Byrne
 */
class DB {

	/**
	 * Single MySQL Connection
	 */
	private static $connection = null;

	/**
	 * Connection
	 * @return Shared \Mysql\Connection object
	 */
	public static function connection() {
	
		if(self::$connection === null) {
		
			$s = Config::get('database');
			self::$connection = new \Mysql\Connection($s['host'], $s['database'], $s['username'], $s['password']);
		
		}
		
		return self::$connection;
	
	}

}