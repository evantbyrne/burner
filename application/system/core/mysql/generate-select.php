<?php

namespace Mysql\Generate;


/* Select */
class Select extends WhereBase {
	
	protected $columns;
	protected $joins;
	protected $offset;
	
	/* Construct */
	public function __construct($table) {
	
		parent::__construct($table);
		$this->columns = array();
		$this->joins = array();
		$this->offset = null;
	
	}
	
	/* Build Column Name */
	protected function build_column_name($column, $alias=false, $func=false) {
		
		$sql = $this->tick_column($column);
		$last = end(explode('.', $column));
		
		// Function (e.g., MAX, MIN)
		if($func !== false) {
			
			$sql = "$func($sql)";
			
		}
		
		// Alias
		$sql .= ($alias === false) ? " AS `$last`" : " AS `$alias`" ;
		return $sql;
		
	}
	
	/* Build Columns */
	protected function build_columns() {
	
		// Columns
		if(count($this->columns) == 0 or in_array('*', $this->columns)) {
			
			// All
			return '*';
			
		} else {

			// Just specified
			$sql = array();
			
			foreach($this->columns as $column) {
				
				if($column['type'] === 'max') {
					
					$sql[] = $this->build_column_name($column['column'], $column['alias'], 'MAX');
					
				} else {
					
					$sql[] = $this->build_column_name($column['column'], $column['alias']);
					
				}
				
			}
			
			return implode(', ', $sql);
			
		}
	
	}
	
	/* Build Joins */
	protected function build_joins() {
		
		$sql = array();
		
		foreach($this->joins as $join) {
			
			$sql[] = "{$join['type']} JOIN `{$join['table']}` ON {$this->tick_column($join['col1'])} {$join['operator']} {$this->tick_column($join['col2'])}";
			
		}
		
		return implode(' ', $sql);
		
	}
	
	/* Build Offset */
	protected function build_offset() {
	
		return "OFFSET {$this->offset}";
	
	}
	
	/* Add Column */
	public function column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'regular', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/* Add Max Column */
	public function max_column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'max', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/* Add Inner Join */
	public function inner_join($table, $col1, $operator, $col2) {
	
		$this->joins[] = array('type'=>'INNER', 'table'=>$table, 'col1'=>$col1, 'operator'=>$operator, 'col2'=>$col2);
		return $this;
	
	}
	
	/* Add Left Join */
	public function left_join($table, $col1, $operator, $col2) {
	
		$this->joins[] = array('type'=>'LEFT', 'table'=>$table, 'col1'=>$col1, 'operator'=>$operator, 'col2'=>$col2);
		return $this;
	
	}
	
	/* Add Right Join */
	public function right_join($table, $col1, $operator, $col2) {
	
		$this->joins[] = array('type'=>'RIGHT', 'table'=>$table, 'col1'=>$col1, 'operator'=>$operator, 'col2'=>$col2);
		return $this;
	
	}
	
	/* Set Offset */
	public function offset($offset) {
	
		if(!preg_match('/^[0-9]+$/', $offset)) {
		
			die('ERROR: Invalid offset.\n');
		
		}
	
		$this->offset = $offset;
		return $this;
	
	}
	
	/* Build */
	public function build() {
	
		$sql = array('SELECT');
		
		// Columns
		$sql[] = $this->build_columns();
		
		// From
		$sql[] = "FROM `{$this->table}`";
		
		// Joins
		if(count($this->joins) > 0) {
		
			$sql[] = $this->build_joins();
		
		}
		
		// Where
		if(count($this->where) > 0) {
		
			$sql[] = $this->build_where();
		
		}
		
		// Order
		if(count($this->order) > 0) {
		
			$sql[] = $this->build_order();
		
		}
		
		// Limit
		if($this->limit !== null) {
		
			$sql[] = $this->build_limit();
		
		}
		
		// Offset
		if($this->offset !== null) {
		
			$sql[] = $this->build_offset();
		
		}
		
		return new Query(implode(' ', $sql), $this->params());
	
	}

}