<?php

namespace Mysql;

/**
 * Abstract Base
 */
abstract class Base {

	protected $connection;
	protected $params;
	
	/**
	 * Construct
	 * @param Connection
	 */
	public function __construct($connection = null) {
	
		$this->connection = $connection;
		$this->params = array();
	
	}
	
	/**
	 * Add Param
	 * @param mixed Param to add
	 * @return $this
	 */
	protected function add_param($param) {
	
		$this->params[] = $param;
		return $this;
	
	}
	
	/**
	 * Params
	 * @return array Params
	 */
	public function params() {
	
		return $this->params;
	
	}

}