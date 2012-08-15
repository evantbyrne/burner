<?php

namespace Column;
use Library\Input;

/**
 * File Column
 * @author Evan Byrne
 */
class File extends Char {
	
	/**
	 * @inheritdoc
	 */
	public function __construct($column_name, $options = array()) {
		
		// Directory
		if(!isset($options['dir'])) {
		
			throw new \Exception("Option 'dir' must be set for $column_name column.");
		
		}
		
		$options = array_merge(array(
			
			'length'    => 5,
			'blank'     => true,
			'template'  => 'file',
			'list'      => false,
			'mimetypes' => null
		
		), $options);
		
		// Valid
		if(!isset($options['valid']) and is_array($options['mimetypes'])) {
			
			$options['valid'] = function($value) use ($options, $column_name) {
				
				if(empty($_FILES[$column_name]['tmp_name'])) {
					
					return true;
					
				}
				
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_file($finfo, $_FILES[$column_name]['tmp_name']);
				
				return (in_array($mime, $options['mimetypes'])) ? true : 'Invalid file type.';
				
			};
			
		}
		
		// Construct
		parent::__construct($column_name, $options);
		
		// Path
		$this->set_method($column_name . '_path', function($model) use ($column_name) {
		
			if(empty($model->{$column_name})) {
				
				return null;
				
			}
			
			return $model->get_schema_column($column_name)->get_option('dir') . '/' . "{$model->id}." . $model->{$column_name};
		
		});
	
	}
	
	/**
	 * @inheritdoc
	 */
	public function set($value) {
		
		if(!empty($value['tmp_name'])) {
			
			$e = explode('.', $value['name']);
			return end($e);
			
		}
		
		return null;
		
	}
	
	/**
	 * @inheritdoc
	 */
	public function finalize($model) {
		
		$name = $this->column_name();
		if(!empty($_FILES[$name]['tmp_name'])) {
			
			$value = $_FILES[$name];
			$e = explode('.', $value['name']);
			$end = array_pop($e);
			$file = $this->get_option('dir') . '/' . "{$model->id}.$end";
			move_uploaded_file($value['tmp_name'], $file);
			
		}
		
	}

}