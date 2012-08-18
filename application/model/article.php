<?php

namespace Model;

/**
 * Example Article Model
 */
class Article extends \Core\Model\Base {
	
	/**
	 * Construct
	 */
	public function __construct() {

		$this->schema(
			new \Column\Varchar('title', array('length' => 125, 'required' => 'Title field is required.')),
			new \Column\Text('content', array('required' => 'Content field is required.')),
			new \Column\Boolean('awesome', array('admin' => false)),
			new \Column\Image('banner', array(
				
				'path' => function($model) {

					if(!is_dir('static/article')) {

						mkdir('static/article', 0755, true);

					}

					return "static/article/{$model->id}";

				}

			)),
			new \Column\HasMany('comments', array('model' => 'Comment', 'column' => 'article'))
		);

	}

	/**
	 * To String
	 * @return string Title
	 */
	public function __toString() {

		return $this->title;

	}

}