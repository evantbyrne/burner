<?php

namespace Column;

/**
 * Many To Many Column
 * @author Evan Byrne
 */
class ManyToMany extends Base {
	
	public function __construct($column_name, $options = array()) {
		
		// Model
		if(!isset($options['model'])) {
		
			throw new \Exception("Option 'model' must be set for $column_name column.");
		
		}

		// Middleman
		if(!isset($options['middleman'])) {
		
			throw new \Exception("Option 'middleman' must be set for $column_name column.");
		
		}
		
		parent::__construct($column_name, array_merge(array('list' => false), $options));
		
		// Selections on remote table
		$model_class = $options['model'];
		$middleman_class = $options['middleman'];
		$this->set_method($column_name, function($parent) use ($model_class, $middleman_class) {
		
			return new ManyToManyQuery($model_class, $middleman_class, $parent);
		
		});
	
	}

}

/**
 * Many To Many Query
 * @author Evan Byrne
 */
class ManyToManyQuery {
	
	private $parent;
	private $parent_class;
	private $model_class;
	private $middleman_class;
	
	/**
	 * Construct
	 */
	public function __construct($model_class, $middleman_class, $parent) {
		
		$this->parent = $parent;
		$this->parent_class = get_class($parent);
		$this->model_class = "\\Model\\$model_class";
		$this->middleman_class = "\\Model\\$middleman_class";
		
	}
	
	/**
	 * Select
	 * @return \Mysql\Select
	 */
	public function select() {
		
		$p = $this->parent_class;
		$p_table = $p::table();
		$m = $this->model_class;
		$m_table = $m::table();
		$middle = $this->middleman_class;
		$middle_table = $middle::table();

		$s = $m::select()
			->inner_join($middle_table, "$middle_table.$m_table", '=', "$m_table.id")
			->where("$middle_table.$p_table", '=', $this->parent->id);

		$child = new $m();
		foreach($child->get_schema() as $name => $column) {

			if($column->column() !== null) {
			
				$s->column("$m_table.$name", $name);

			}

		}

		return $s;
		
	}

}