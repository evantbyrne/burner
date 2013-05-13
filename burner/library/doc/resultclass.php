<?php

namespace Library;

class Doc_ResultClass {

	/**
	 * ReflectionClass
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
	 * array An array of Library\Doc_ResultProperty
	 */
	protected $properties;

	/**
	 * array An array of Library\Doc_ResultMethod
	 */
	protected $methods;

	/**
	 * Constructor
	 * @param ReflectionClass
	 * @param string Title, which may be null
	 * @param string Description, which may be null
	 * @param array An array of Library\Doc_ResultTag
	 * @param array An array of Library\Doc_ResultProperty
	 * @param array An array of Library\Doc_ResultMethod
	 */
	public function __construct($reflection, $title = null, $description = null, $tags = array(), $properties = array(), $methods = array()) {

		$this->reflection = $reflection;
		$this->title = $title;
		$this->description = $description;
		$this->tags = $tags;
		$this->properties = $properties;
		$this->methods = $methods;

	}

	/**
	 * Get Reflection
	 * @return ReflectionClass
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

	/**
	 * Get Properties
	 * @return array An array of Library\Doc_ResultProperty
	 */
	public function get_properties() {

		return $this->properties;

	}

	/**
	 * Get Methods
	 * @return array An array of Library\Doc_ResultMethod
	 */
	public function get_methods() {

		return $this->methods;

	}

	/**
	 * Get Method By Name
	 * @param string Method name
	 * @return Library\Doc_ResultMethod
	 */
	public function get_method_by_name($name) {

		foreach($this->methods as $method) {

			if($method->get_reflection()->getName() === $name) {

				return $method;

			}

		}

		return null;

	}

}