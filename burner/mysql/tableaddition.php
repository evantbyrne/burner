<?php

namespace Mysql;

/**
 * Abstract Table Addition
 */
abstract class TableAddition {

	protected $values;
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		$this->values = func_get_args();
	
	}
	
	/**
	 * Build
	 * @return String representing addition portion of SQL query
	 */
	public abstract function build();

}