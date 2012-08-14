<?php

namespace Column;

/**
 * Has Many Column
 * @author Evan Byrne
 */
class HasMany extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		// Column
		if(!isset($options['column'])) {
		
			throw new \Exception("Option 'column' must be set for $column_name column.");
		
		}
		
		parent::__construct($column_name, array_merge(array('model' => $column_name, 'list' => false), $options));
		
		// Selections on remote table
		$model_class = $options['model'];
		$column = $options['column'];
		$this->set_method($column_name, function($model) use ($column_name, $model_class, $column) {
		
			return new HasManyQuery($model_class, $column, $model->id);
		
		});
	
	}

}

/**
 * Has Many Query
 * @author Evan Byrne
 */
class HasManyQuery {
	
	private $column;
	private $id;
	private $model_class;
	
	/**
	 * Construct
	 */
	public function __construct($model, $column, $id) {
		
		$this->column = $column;
		$this->id = $id;
		$this->model_class = "\\Model\\$model";
		
	}
	
	/**
	 * Select
	 * @return \Mysql\Select
	 */
	public function select() {
		
		$m = $this->model_class;
		return $m::select()->where($this->column, '=', $this->id);
		
	}
	
	/**
	 * Delete
	 * @return \Mysql\Delete
	 */
	public function delete() {
		
		$m = $this->model_class;
		return $m::delete()->where($this->column, '=', $this->id);
		
	}
	
	/**
	 * Update
	 * @return \Mysql\Update
	 */
	public function update() {
		
		$m = $this->model_class;
		return $m::update()->where($this->column, '=', $this->id);
		
	}
	
	/**
	 * Insert
	 * @return \Mysql\Insert
	 */
	public function insert() {
		
		$m = $this->model_class;
		return $m::insert()->value($this->column, $this->id);
		
	}

}