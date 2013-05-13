<?php

namespace Library;

class Doc_ResultMethod {

	/**
	 * ReflectionMethod
	 */
	protected $reflection;

	/**
	 * string Title, which may be null
	 */
	protected $title;

	/**
	 * string Description, which may be null
	 */
	protected $description;

	/**
	 * array An array of Library\Doc_ResultTag
	 */
	protected $tags;

	/**
	 * Constructor
	 * @param ReflectionMethod
	 * @param string Title, which may be null
	 * @param string Description, which may be null
	 * @param array An array of Library\Doc_ResultTag
	 */
	public function __construct($reflection, $title = null, $description = null, $tags = array()) {

		$this->reflection = $reflection;
		$this->title = $title;
		$this->description = $description;
		$this->tags = $tags;

	}

	/**
	 * Get Reflection
	 * @return ReflectionMethod
	 */
	public function get_reflection() {

		return $this->reflection;

	}

	/**
	 * Get Title
	 * @return string Title, which can be null
	 */
	public function get_title() {

		return $this->title;

	}

	/**
	 * Get Description
	 * @return string Description, which can be null
	 */
	public function get_description() {

		return $this->description;

	}

	/**
	 * Get Tags
	 * @return array An array of Library\Doc_ResultTag
	 */
	public function get_tags() {

		return $this->tags;

	}

}