<?php

namespace Library\Template;

/**
 * Standard Template Class
 * @author Evan Byrne
 */
class Standard implements BaseInterface {
	
	private $extensions = array();
	private $sections = array();
	private $appends = array();
	private $current_section = false;
	private $current_new_section = false;
	private $out;
	private $data;
	private $first;
	
	/**
	 * @inheritdoc
	 */
	public static function render($template, $data = array()) {
	
		$v = new Standard($template, $data);
		return $v->output();
	
	}
	
	/**
	 * Construct
	 * @param string Template
	 * @param array Data
	 */
	public function __construct($template, $data = array()) {
		
		$this->out = '';
		$this->data = $data;
		$this->first = true;
		$this->load($template, $data);
		
		// Load extensions
		foreach($this->extensions as $e) {
		
			$this->load($e['template'], $e['data']);
		
		}
		
		$this->out .= ob_get_clean();
		ob_start();
	
	}
	
	/**
	 * Output
	 * @return string
	 */
	public function output() {
	
		return $this->out;
	
	}
	
	/**
	 * Exists
	 * @param string Template
	 * @return boolean
	 */
	public function exists($template) {
		
		return file_exists(APPLICATION . "/template/$template.php");
		
	}
	
	/**
	 * Load
	 * @param string Template
	 * @param array Data
	 */
	public function load($template, $data = NULL) {
		
		// If view does not exist display error
		if(!file_exists(APPLICATION . "/template/$template.php")) {
			
			throw new \Exception('The requested template ('. APPLICATION. "/template/$template.php) could not be found.");
			
		}
		
		// If data is array, convert keys to variables
		if(is_array($data)) {
			
			extract($data, EXTR_OVERWRITE);
		
		}
		
		require(APPLICATION . "/template/$template.php");
		
	}
	
	/**
	 * Base
	 * @param string Template
	 * @param array Data
	 */
	public function base($template, $data=array()) {
	
		$this->extensions[] = array('template'=>$template, 'data'=>$data);
	
	}
	
	/**
	 * Extend
	 * @param string Section name
	 */
	public function extend($name) {
	
		ob_clean();
		$this->current_section = $name;
		$this->out .= ob_get_clean();
		ob_start();
	
	}
	
	/**
	 * End Extend
	 */
	public function end_extend() {
	
		$data = ob_get_clean();
		$this->sections[$this->current_section] = $data;
		
		if(isset($this->appends[$this->current_section])) {

			unset($this->appends[$this->current_section]);

		}

		$this->current_section = false;
		ob_start();
	
	}

	/**
	 * Append
	 * @param string Section name
	 */
	public function append($name) {
	
		$this->extend($name);
	
	}
	
	/**
	 * End Append
	 */
	public function end_append() {
	
		$data = ob_get_clean();
		$this->appends[$this->current_section] = (isset($this->appends[$this->current_section])) ? $this->appends[$this->current_section] . $data : $data;
		$this->current_section = false;
		ob_start();
	
	}

	/**
	 * Set
	 * @param string Section name
	 * @param string Data
	 */
	public function set($name, $data) {

		$this->sections[$name] = $data;

	}
	
	/**
	 * Section
	 * @param string Section name
	 * @param boolean Default
	 */
	public function section($name, $default=true) {
	
		if(!$default) {
		
			echo $this->sections[$name];
			
		} else {
			
			$this->current_new_section = $name;
			$this->out .= ob_get_clean();
			ob_start();
		
		}
	
	}
	
	/**
	 * End Section
	 */
	public function end_section() {
	
		if(isset($this->sections[$this->current_new_section])) {
		
			ob_clean();
			echo $this->sections[$this->current_new_section];
		
		}

		if(isset($this->appends[$this->current_new_section])) {

			echo  $this->appends[$this->current_new_section];

		}
		
		$this->current_new_section = false;
	
	}

	/**
	 * Error
	 * @param string Name of error
	 */
	public function error($error) {

		if(isset($this->data['errors'][$error])) {

			echo self::render('error/form', array('content' => $this->data['errors'][$error]));

		}

	}

	/**
	 * First
	 * @return boolean
	 */
	public function first() {

		if($this->first === true) {

			$this->first = false;
			return true;

		}

		return false;

	}
	
	/**
	 * Reset First
	 */
	public function reset_first() {

		$this->first = true;

	}

	/**
	 * Field
	 * @param string Field name
	 * @param \Core\Model\Base Model
	 * @param array Extra options
	 */
	public function field($name, $model, $extra_options = array()) {

		$options = array_merge($model->get_schema_column($name)->options(), $extra_options);
		echo self::render("field/{$options['template']}", array(
			
			'field'   => $name,
			'options' => $options,
			'value'   => isset($model->{$name}) ? $model->{$name} : null,
			'errors'  => isset($this->data['errors']) ? $this->data['errors'] : null,
			'model'   => $model

		));

	}

	/**
	 * Label
	 * @param string Field Name
	 */
	public function label($field) {

		echo self::render("field/label", array(

			'field'  => $field,
			'label'  => str_replace('_', ' ', $field),
			'errors' => isset($this->data['errors']) ? $this->data['errors'] : null

		));

	}
	
}