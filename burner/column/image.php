<?php

namespace Column;

/**
 * Image Column
 * @author Evan Byrne
 */
class Image extends File {
	
	/**
	 * @inheritdoc
	 */
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, array_merge(array(
			'mimetypes'     => array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'),
			'template'      => 'image',
			'admin_list'    => true,
			'list_template' => 'image'
		), $options));
		
	}
	
}