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
		
		// Mime types
		if(!isset($options['mimetypes'])) {
		
			throw new \Exception("Option 'mimetypes' must be set for $column_name column.");
		
		}
		
		$options = array_merge(array(
			
			'length'     => 5,
			'blank'      => true,
			'template'   => 'file',
			'admin_list' => false,
			'mimetypes'  => null
		
		), $options);
		
		// Valid
		if(!isset($options['valid'])) {
			
			$options['valid'] = function($value) {
				
				return ($value === false) ? 'Invalid file type.' : true;
				
			};
			
		}
		
		// Construct
		parent::__construct($column_name, $options);

		// File URL
		$this->set_method($column_name . '_url', function($model) use ($column_name) {

			return url($model->{$column_name . '_path'}() . '.' . $model->{$column_name});

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
			
			$file = $model->{$name . '_path'}();
			foreach(array_unique(array_values($this->get_option('mimetypes'))) as $ext) {
				
				if(file_exists("$file.$ext")) {
					
					unlink("$file.$ext");
					
				}
				
			}
			
			move_uploaded_file($_FILES[$name]['tmp_name'], "$file.{$model->{$name}}");
			
		}
		
	}

}