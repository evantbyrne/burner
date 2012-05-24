<?php

namespace Model\Base;

/**
 * Base Session Model
 * @author Evan Byrne
 */
abstract class Session extends Root {

	protected static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=_';
	
	/**
	 * Blocks
	 * @return Array of blocks that make up model
	 */
	public static function blocks() {
	
		return array(
		
			new \Block\Text('secret', array('unique'=>true))
		
		);
	
	}
	
	/**
	 * Get
	 * @param Secret session value
	 * @return \Model\Base\Session object or false
	 */
	public static function get($secret) {
	
		$select = new \Model\Query\Select(self::table(), '\\'.get_called_class());
		$res = $select->where('secret', '=', $secret)->limit(1)->execute();
		return (empty($res)) ? false : $res[0];
	
	}
	
	/**
	 * Secret
	 * @param Minimum length of random range
	 * @param Maximum length of random range
	 * @return A mixture of random characters
	 */
	public static function secret($min=10, $max=30) {
		
		$len = rand($min, $max);
		$salt = '';

		for($i = 0; $i < $len; $i++) {
		
			$char = substr(static::$chars, mt_rand(0, strlen(static::$chars) - 1), 1);
			$salt .= $char;
		
		}
		
		return $salt;
	
	}
	
	/**
	 * Insert
	 * @return Generated secret representing session
	 */
	public function insert() {
	
		$this->secret = static::secret();
		parent::insert();
		return $this->secret;
	
	}
	
	/**
	 * Delete
	 * @param Boolean if the query should be executed right away (default true)
	 * @return Result of query if execute is true, \Model\Query object otherwise
	 */
	public function delete($execute = true) {
	
		$delete = parent::delete(false);
		return ($execute) ? $delete->execute() : $delete;
	
	}

}