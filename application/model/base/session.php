<?php

namespace Model\Base;

/**
 * Base Session Model
 * @author Evan Byrne
 */
class Session extends Root {

	protected static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=_';
	
	/**
	 * Blocks
	 * @return Array of blocks that make up model
	 */
	public static function blocks() {
	
		return array(
		
			new \Block\Text('secret', array('unique'=>true)),
			new \Block\Text('value'),
			new \Block\Text('expire')
		
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
	 * Set
	 * @param \Model\Base\Session object or false
	 * @return Generated secret representing session
	 */
	public static function set($value) {
	
		$insert = new \Model\Query\Insert(self::table());
		$secret = static::secret();
		$insert->value('secret', $secret)->value('value', $value)->execute();
		return $secret;
	
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
	 * Delete
	 * @param Boolean if the query should be executed right away (default true)
	 * @return Result of query if execute is true, \Model\Query object otherwise
	 */
	public function delete($execute = true) {
	
		$delete = parent::delete(false);
		return ($execute) ? $delete->execute() : $delete;
	
	}

}