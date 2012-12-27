<?php

namespace Core\Form;

/**
 * Base Form
 * All forms should extend this.
 * @author Evan Byrne
 */
class Base {

	/**
	 * array MySQL schema
	 */
	private static $schema = array();
	
	/**
	 * array Admin columns
	 */
	private static $admin = array();

	/**
	 * From Array
	 * @param array Associated array of data
	 * @param mixed Whitelist or null
	 * @return \Model\Base Populated model object
	 */
	public static function from_array($data, $whitelist = null) {
	
		$instance = new static();
		$schema = $instance->get_schema();
		
		foreach($schema as $name => $column) {
		
			$default = $column->get_option('default');
			
			if(($whitelist === null or in_array($name, $whitelist)) and isset($data[$name])) {

				$instance->{$name} = (is_callable(array($column, 'set'))) ? $column->set($data[$name]) : $data[$name];

			} elseif(is_callable($default)) {
				
				$instance->{$name} = $default();
				
			}
		
		}
		
		return $instance;
	
	}
	
	/**
	 * From Post
	 * @param mixed Whitelist or null
	 * @return \Model\Base Model object populated from $_POST
	 */
	public static function from_post($whitelist = null, $include_files = false) {
		
		return self::from_array(($include_files) ? array_merge($_POST, $_FILES) : $_POST, $whitelist);
		
	}

	/**
	 * ReflectionClass
	 */
	private $klass;

	/**
	 * string Class Name
	 */
	private $klass_name;

	/**
	 * boolean Whether methods array has been populated
	 */
	private $_methods_set;
	
	/**
	 * array Methods dynamically set by columns
	 */
	private $_methods;
	
	/**
	 * Construct
	 */
	public function __construct() {

		$this->klass = new \ReflectionClass($this);
		$this->klass_name = $this->klass->getName();
		$this->_admin = array();
		$this->_methods_set = false;
		$this->_methods = array();

		// Generate schema
		if(empty(self::$schema[$this->klass_name])) {
		
			$properties = $this->klass->getProperties();
			foreach($properties as $property) {

				// Loop doc comment lines
				$name = $property->getName();
				$options = \Library\DocComment::options($property);

				// Choices option
				if(isset($options['choices']) and $options['choices'] === true) {

					$options['choices'] = static::${$name . '_choices'};

				}

				// Add column
				if(!empty($options) and !empty($options['type'])) {

					$column_class = "\\Column\\{$options['type']}";
					self::$schema[$this->klass_name][$name] = new $column_class($name, $options);

					// Add to admin
					if(self::$schema[$this->klass_name][$name]->get_option('admin')) {

						$this->admin($name, $options);

					}

				}

			}

		}

	}

	/**
	 * Get Schema
	 * @return array
	 */
	public function get_schema() {
		
		return self::$schema[$this->klass_name];

	}
	
	/**
	 * Get Schema Column
	 * @param string Column name
	 * @return mixed \Column\Base, or null
	 */
	public function get_schema_column($name) {
		
		return (isset(self::$schema[$this->klass_name][$name])) ? self::$schema[$this->klass_name][$name] : null;
		
	}

	/**
	 * Admin
	 * @param string Column
	 * @param array Options
	 */
	public function admin($column, $options = array()) {

		self::$admin[$this->klass_name][$column] = array_merge(array('list' => true), $this->get_schema_column($column)->options(), $options);

	}

	/**
	 * Get Admin
	 * @return array
	 */
	public function get_admin() {

		return self::$admin[$this->klass_name];

	}

	/**
	 * Valid
	 * @return True if valid, an associative array of errors otherwise
	 */
	public function valid() {
	
		$errors = array();
		$schema = $this->get_schema();
		
		foreach($schema as $name => $column) {
		
			$res = $column->valid($this);
			if($res !== true) {
			
				$errors[$name] = $res;
			
			}
		
		}
		
		return (empty($errors)) ? true : $errors;
	
	}

	/**
	 * Merge Array
	 * @param array Associated array of data
	 * @param mixed Whitelist array or null
	 * @return $this
	 */
	public function merge_array($data, $whitelist = null) {
	
		$schema = $this->get_schema();
		
		foreach($schema as $name => $column) {
		
			if(($whitelist === null or in_array($name, $whitelist)) and isset($data[$name])) {

				if(!empty($data[$name]) or !$column->get_option('blank')) {

					if(!empty($data[$name]['tmp_name']) or !is_a($column, '\\Column\\File')) {

						$this->{$name} = (is_callable(array($column, 'set'))) ? $column->set($data[$name]) : $data[$name];

					}

				}

			}
		
		}
		
		return $this;
	
	}
	
	/**
	 * Merge Post
	 * @param mixed Whitelist array or null
	 * @return $this
	 */
	public function merge_post($whitelist = null, $include_files = false) {
	
		return $this->merge_array(($include_files) ? array_merge($_POST, $_FILES) : $_POST, $whitelist);
	
	}
	
	/**
	 * To Array
	 * @param mixed Whitelist array or null
	 * @return array Associated array of data from model instance
	 */
	public function to_array($whitelist = null) {
	
		$data = array();
		$schema = $this->get_schema();
		$schema['id'] = new \Column\Int('id');
		
		foreach($schema as $name => $column) {
		
			if(($whitelist === null or in_array($name, $whitelist))) {

				$data[$name] = (isset($this->$name)) ? $this->$name : null;

			}
		
		}
		
		return $data;
	
	}

	/**
	 * Call
	 * @param Name of method
	 * @param Arguments
	 * @return Mixed
	 */
	public function __call($method, $args) {
		
		if(!$this->_methods_set) {
			
			foreach($this->get_schema() as $addition) {

				$methods = $addition->methods();
				foreach($methods as $name => $func) {
					
					$this->_methods[$name] = $func;
					
				}

			}
			
			$this->_methods_set = true;
			
		}
		
		if(isset($this->_methods[$method]) and is_callable($this->_methods[$method])) {
		
			$func = $this->_methods[$method];
			array_unshift($args, $this);
			return call_user_func_array($func, $args);
			
		}
		
	}

}