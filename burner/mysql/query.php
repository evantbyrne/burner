<?php

namespace Mysql;

/**
 * Query Class
 */
class Query {

	protected $sql;
	protected $params;
	
	/**
	 * Construct
	 * @param string SQL
	 * @param array Params to be inserted into SQL
	 */
	public function __construct($sql, $params=array()) {
	
		$this->sql = $sql;
		$this->params = $params;
	
	}
	
	/**
	 * SQL
	 * @return string SQL
	 */
	public function sql() {
	
		return $this->sql;
	
	}
	
	/**
	 * Params
	 * @return array Params
	 */
	public function params() {
	
		return $this->params;
	
	}

}