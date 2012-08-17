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
		
		// Mime types
		if(!isset($options['mimetypes'])) {
		
			throw new \Exception("Option 'mimetypes' must be set for $column_name column.");
		
		}
		
		$options = array_merge(array(
			
			'length'    => 5,
			'blank'     => true,
			'template'  => 'file',
			'list'      => false,
			'mimetypes' => null
		
		), $options);
		
		// Valid
		if(!isset($options['valid'])) {
			
			$options['valid'] = function($value) {
				
				return ($value === false) ? 'Invalid file type.' : true;
				
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
			
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $value['tmp_name']);
			$mimetypes = $this->get_option('mimetypes');
			
			return (!empty($mimetypes[$mime])) ? $mimetypes[$mime] : false;
			
		}
		
		return null;
		
	}
	
	/**
	 * @inheritdoc
	 */
	public function finalize($model) {
		
		$name = $this->column_name();
		if(!empty($_FILES[$name]['tmp_name'])) {
			
			$file = $this->get_option('dir') . '/' . "{$model->id}";
			
			foreach(array_unique(array_values($this->get_option('mimetypes'))) as $ext) {
				
				if(file_exists("$file.$ext")) {
					
					unlink("$file.$ext");
					
				}
				
			}
			
			move_uploaded_file($_FILES[$name]['tmp_name'], "$file.{$model->{$name}}");
			
		}
		
	}

}