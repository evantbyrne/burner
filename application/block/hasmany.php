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
	 * @return \Model\Query\Select object
	 */
	public function select() {
		
		$query = new \Model\Query\Select(call_user_func("{$this->model_class}::table"), $this->model_class);
		$query->where($this->column, '=', $this->id);
		return $query;
		
	}
	
	/**
	 * Delete
	 * @return \Model\Query\Delete object
	 */
	public function delete() {
		
		$query = new \Model\Query\Delete(call_user_func("{$this->model_class}::table"));
		$query->where($this->column, '=', $this->id);
		return $query;
		
	}
	
	/**
	 * Update
	 * @param Model instance to insert values from
	 * @return Result of database query
	 */
	public function update($instance) {
		
		$query = new \Model\Query\Update(call_user_func("{$this->model_class}::table"));
		$query->where($this->column, '=', $this->id);
		
		$blocks = call_user_func("{$this->model_class}::blocks");
		foreach($blocks as $block) {
		
			$col = $block->column_name();
			if($col !== 'id' and isset($instance->$col)) {
				
				$query->value($col, $instance->$col);
			
			}
		
		}
		
		return $query;
		
	}
	
	/**
	 * Insert
	 * @param Model instance to be inserted
	 * @return Result of database query
	 */
	public function insert($insertion) {
		
		$insertion->{$this->column} = $this->id;
		return $insertion->insert();
		
	}

}