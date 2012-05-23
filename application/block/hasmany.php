<?php

namespace Block;

/**
 * Has Many Block
 * @author Evan Byrne
 */
class HasMany extends Base {
	
	private $model;
	private $column;
	
	public function __construct($column_name, $options = array()) {
		
		parent::__construct($column_name, $options);
		
		// Model
		$model_class = (isset($options['model'])) ? $options['model'] : $column_name;
		$this->model = $model_class;
		
		// Column
		if(!isset($options['column'])) {
		
			throw new \Exception("Option 'column' must be set for $column_name column.");
		
		}
		
		$model_class_column = $options['column'];
		$this->column = $model_class_column;
		
		// Selections on remote table
		$this->set_method($column_name, function($model) use ($column_name, $model_class, $model_class_column) {
		
			return new HasManyQuery($model_class, $model_class_column, $model->id);
		
		});
	
	}

}

/**
 * Has Many Query
 * @author Evan Byrne
 */
class HasManyQuery {
	
	private $model;
	private $column;
	private $id;
	
	/**
	 * Construct
	 */
	public function __construct($model, $column, $id) {
		
		$this->model = $model;
		$this->column = $column;
		$this->id = $id;
		
	}
	
	/**
	 * Insert
	 * @param Model instance to be inserted
	 */
	public function insert($insertion) {
		
		$insertion->{$this->column} = $this->id;
		return $insertion->insert();
		
	}

}