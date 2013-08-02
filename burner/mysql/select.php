<?php

namespace Mysql;

/**
 * Select
 */
class Select extends WhereBase {
	
	protected $columns;
	protected $joins;
	protected $offset;
	protected $result_class;
	
	/**
	 * Construct
	 * @param string Table
	 * @param Connection
	 */
	public function __construct($table, $result_class = null, $connection = null) {
	
		parent::__construct($table, $connection);
		$this->columns = array();
		$this->joins = array();
		$this->offset = null;
		$this->result_class = ($result_class === null) ? '\\Mysql\\Result' : $result_class;
	
	}
	
	/**
	 * Build Column Name
	 * @param string Column to build
	 * @param string Alias for column
	 * @param boolean True if a function like MIN, MAX, or COUNT
	 * @return string This column's portion of the SQL statement
	 */
	protected function build_column_name($column, $alias=false, $func=false) {
		
		$sql = $this->tick_column($column);
		$tmp = explode('.', $column);
		$last = end($tmp);
		
		// Function (e.g., MAX, MIN)
		if($func !== false) {
			
			$sql = "$func($sql)";
			
		}
		
		// Alias
		$sql .= ($alias === false) ? " AS `$last`" : " AS `$alias`" ;
		return $sql;
		
	}
	
	/**
	 * Build Columns
	 * @return string Column selection portion of SQL statement
	 */
	protected function build_columns() {
	
		// Columns
		if(count($this->columns) == 0 or in_array('*', $this->columns)) {
			
			// All
			return '*';
			
		} else {

			// Just specified
			$sql = array();
			
			foreach($this->columns as $column) {
				
				if(in_array($column['type'], array('min', 'max', 'count', 'sum', 'avg'))) {
					
					$sql[] = $this->build_column_name($column['column'], $column['alias'], strtoupper($column['type']));
					
				} else {
					
					$sql[] = $this->build_column_name($column['column'], $column['alias']);
					
				}
				
			}
			
			return implode(', ', $sql);
			
		}
	
	}
	
	/**
	 * Build Joins
	 * @return string JOIN portion of SQL statement
	 */
	protected function build_joins() {
		
		$sql = array();
		
		foreach($this->joins as $join) {
			
			$sql[] = "{$join['type']} JOIN `{$join['table']}` ON {$this->tick_column($join['col1'])} {$join['operator']} {$this->tick_column($join['col2'])}";
			
		}
		
		return implode(' ', $sql);
		
	}
	
	/**
	 * Build Offset
	 * @return string OFFSET portion of SQL statement
	 */
	protected function build_offset() {
	
		return "OFFSET {$this->offset}";
	
	}
	
	/**
	 * Column
	 * @param string Column
	 * @param string Alias
	 * @return $this
	 */
	public function column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'regular', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/**
	 * Min Column
	 * @param string Column
	 * @param string Alias
	 * @return $this
	 */
	public function min_column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'min', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/**
	 * Max Column
	 * @param string Column
	 * @param string Alias
	 * @return $this
	 */
	public function max_column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'max', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/**
	 * Count Column
	 * @param string Column
	 * @param string Alias
	 * @return $this
	 */
	public function count_column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'count', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/**
	 * Sum Column
	 * @param string Column
	 * @param string Alias
	 * @return $this
	 */
	public function sum_column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'sum', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/**
	 * Avg Column
	 * @param string Column
	 * @param string Alias
	 * @return $this
	 */
	public function avg_column($column, $alias=false) {
	
		$this->columns[] = array('type'=>'avg', 'column'=>$column, 'alias'=>$alias);
		return $this;
	
	}
	
	/**
	 * Inner Join
	 * @param string Table to INNER JOIN
	 * @param string First column to compare
	 * @param string Column comparison operator
	 * @param string Second column to compare
	 * @return $this
	 */
	public function inner_join($table, $col1, $operator, $col2) {
	
		$this->joins[] = array('type'=>'INNER', 'table'=>$table, 'col1'=>$col1, 'operator'=>$operator, 'col2'=>$col2);
		return $this;
	
	}
	
	/**
	 * Left Join
	 * @param string Table to INNER JOIN
	 * @param string First column to compare
	 * @param string Column comparison operator
	 * @param string Second column to compare
	 * @return $this
	 */
	public function left_join($table, $col1, $operator, $col2) {
	
		$this->joins[] = array('type'=>'LEFT', 'table'=>$table, 'col1'=>$col1, 'operator'=>$operator, 'col2'=>$col2);
		return $this;
	
	}
	
	/**
	 * Right Join
	 * @param string Table to INNER JOIN
	 * @param string First column to compare
	 * @param string Column comparison operator
	 * @param string Second column to compare
	 * @return $this
	 */
	public function right_join($table, $col1, $operator, $col2) {
	
		$this->joins[] = array('type'=>'RIGHT', 'table'=>$table, 'col1'=>$col1, 'operator'=>$operator, 'col2'=>$col2);
		return $this;
	
	}
	
	/**
	 * Offset
	 * @param int Offset
	 * @return $this
	 */
	public function offset($offset) {
	
		if(!preg_match('/^[0-9]+$/', $offset)) {
		
			die('ERROR: Invalid offset.\n');
		
		}
	
		$this->offset = $offset;
		return $this;
	
	}

	/**
	 * Page
	 * @param int Current page
	 * @param int Number of records per page
	 * @return $this
	 */
	public function page($page, $page_record_limit) {

		$this->limit($page_record_limit);
		$this->offset(($page - 1) * $page_record_limit);
		return $this;

	}
	
	/**
	 * Build
	 * @return Query
	 */
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
	
	/**
	 * Fetch
	 * @return array Objects of type set in first param
	 */
	public function fetch() {
	
		if(isset($this->connection)) {
		
			return $this->connection->fetch($this->build(), $this->result_class);
		
		}
	
	}
	
	/**
	 * Single
	 * @return mixed Result object or null
	 */
	public function single() {
	
		if(isset($this->connection)) {
		
			$res = $this->limit(1)->fetch();
			return (empty($res)) ? null : $res[0];
		
		}
	
	}

}