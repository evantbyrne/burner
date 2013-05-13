<?php

namespace Library;

class Doc_ResultTag {
	
	/**
	 * string Name
	 */
	protected $name;

	/**
	 * string Value, which may be null
	 */
	protected $value;

	/**
	 * Constructor
	 * @param string Name
	 * @param string Value, which may be null
	 */
	public function __construct($name, $value = null) {

		$this->name = $name;
		$this->value = $value;

	}

	/**
	 * Get Name
	 * @return string Name
	 */
	public function get_name() {

		return $this->name;

	}

	/**
	 * Get Value
	 * @return string Value, which may be null
	 */
	public function get_value() {

		return $this->value;

	}

}