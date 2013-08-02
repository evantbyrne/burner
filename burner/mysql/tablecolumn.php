<?php

namespace Mysql;

/**
 * Abstract Table Column
 */
abstract class TableColumn {

	protected $name;
	protected $options;
	
	/**
	 * Construct
	 * @param string Table
	 * @param array Options
	 */
	public function __construct($name, $options=array()) {
	
		$this->name = $name;
		$this->options = $options;
	
	}
	
	/**
	 * Option
	 * @param string Key
	 * @param mixed Value
	 * @return $this
	 */
	public function option($key, $value) {
	
		$this->options[$key] = $value;
		return $this;
	
	}
	
	/**
	 * Build Null
	 * @return string NULL portion of SQL query
	 */
	public function build_null() {
	
		// Nothing, NULL, or NOT NULL
		return (isset($this->options['null'])) ? (($this->options['null'] === true) ? ' NULL' : ' NOT NULL') : '';
	
	}
	
	/**
	 * Build
	 * @return string Column portion of SQL query
	 */
	public abstract function build();

}