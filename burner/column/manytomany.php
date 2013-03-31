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
	private $parent_table;
	private $child_class;
	private $child_table;
	private $middleman_class;
	private $middleman_table;
	
	/**
	 * Construct
	 * @param string Child class
	 * @param string Middleman class
	 * @param \Core\Model\Base Parent
	 */
	public function __construct($child_class, $middleman_class, $parent) {
		
		$this->parent = $parent;
		$parent_class = get_class($parent);
		$this->parent_table = $parent_class::table();
		
		$child_class = "\\App\\Model\\$child_class";
		$this->child_class = $child_class;
		$this->child_table = $child_class::table();

		$middleman_class = "\\App\\Model\\$middleman_class";
		$this->middleman_class = $middleman_class;
		$this->middleman_table = $middleman_class::table();
		
	}
	
	/**
	 * Select
	 * @return \Mysql\Select
	 */
	public function select() {
		
		$m = $this->child_class;
		$s = $m::select()
			->inner_join($this->middleman_table, "{$this->middleman_table}.{$this->child_table}", '=', "{$this->child_table}.id")
			->where("{$this->middleman_table}.{$this->parent_table}", '=', $this->parent->id);

		$child = new $m();
		foreach($child->get_schema() as $name => $column) {

			if($column->column() !== null) {
			
				$s->column("{$this->child_table}.$name", $name);

			}

		}

		return $s;
		
	}

	/**
	 * Add
	 * @param int Child row ID
	 * @return int Inserted middleman row ID
	 */
	public function add($child_id) {

		$middle = $this->middleman_class;
		return $middle::insert()
			->value($this->parent_table, $this->parent->id)
			->value($this->child_table, $child_id)
			->execute();

	}

	/**
	 * Remove
	 * @param int Child row ID
	 * @return mixed Result of delete query
	 */
	public function remove($child_id) {

		$middle = $this->middleman_class;
		return $middle::delete()
			->where($this->parent_table, '=', $this->parent->id)
			->and_where($this->child_table, '=', $child_id)
			->execute();

	}

}