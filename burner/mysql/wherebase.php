<?php

namespace Mysql;

/**
 * Abstract Where Base Class
 */
abstract class WhereBase extends Base {

	protected $table;
	protected $where;
	protected $order;
	protected $limit;
	
	/**
	 * Construct
	 * @param string Table
	 * @param Connection
	 */
	public function __construct($table, $connection = null) {
	
		parent::__construct($connection);
		$this->table = $table;
		$this->where = array();
		$this->order = array();
		$this->limit = null;
	
	}
	
	/**
	 * Tick Column
	 * @param string Column name
	 * @return string Formatted column name
	 */
	protected function tick_column($column) {
		
		$parts = explode('.', $column);
		for($i = 0; $i < count($parts); $i++) {
		
			$parts[$i] = "`{$parts[$i]}`";
		
		}
		
		return implode('.', $parts);
		
	}
	
	/**
	 * Build Where
	 * @return string WHERE portion of SQL query
	 */
	protected function build_where() {
			
		$sql = 'WHERE';
		
		foreach($this->where as $i) {
			
			// Regular
			if($i['type'] == 'column') {
				
				// MATCH
				if($i['operator'] == 'MATCH' or $i['operator'] == 'MATCH_BOOLEAN') {

					$i['column'] = (is_array($i['column'])) ? $i['column'] : array($i['column']);
					
					$cols = array();
					foreach($i['column'] as $column) {
					
						$cols[] = $this->tick_column($column);
					
					}
					
					$sql .= ' MATCH(' . implode(', ', $cols) . ") AGAINST (?" . (($i['operator'] == 'MATCH_BOOLEAN') ? ' IN BOOLEAN MODE' : '') . ')';

				// Regular
				} else {
					
					$sql .= " {$this->tick_column($i['column'])} {$i['operator']} ?";
						
				}
				
				$this->add_param($i['value']);
				
			// NULL
			} elseif($i['type'] == 'null') {
			
				$sql .= " {$this->tick_column($i['column'])} IS NULL";
			
			// NOT NULL
			} elseif($i['type'] == 'not_null') {
			
				$sql .= " {$this->tick_column($i['column'])} IS NOT NULL";
				
			// Grouping
			} elseif($i['type'] == 'start_group') {
				
				$sql .= ' (';
			
			} elseif($i['type'] == 'end_group') {
				
				$sql .= ' )';
			
			// TODO: Remove?
			} elseif($i['type'] == 'on') {
					
				$sql .= " {$this->tick_column($i['col1'])} {$i['operator']} {$this->tick_column($i['col2'])}";
			
			// Clauses
			} elseif($i['type'] == 'clause') {
					
				$sql .= " {$i['clause']}";
					
			}

		}

		return $sql;
		
	}
	
	/**
	 * Build Order
	 * @return string ORDER section of SQL query
	 */
	protected function build_order() {
	
		$sql = array();
		
		foreach($this->order as $ord) {
		
			$sql[] = "{$this->tick_column($ord['column'])} {$ord['direction']}";
		
		}
		
		return 'ORDER BY ' . implode(', ', $sql);
	
	}
	
	/**
	 * Build Limit
	 * @return string LIMIT section of SQL query
	 */
	protected function build_limit() {
	
		return "LIMIT {$this->limit}";
	
	}
	
	/**
	 * Is Valid Where Operator
	 * @param string Operator to check
	 * @return boolean True if valid, false otherwise
	 */
	protected function is_valid_where_operator($operator) {
	
		return in_array($operator, array('=', '!=', '<', '>', '<=', '>=', 'LIKE', 'MATCH', 'MATCH_BOOLEAN'));
	
	}
	
	/**
	 * Where
	 * @param string Column to compare
	 * @param string Operator
	 * @param string Value to compare
	 * @return $this
	 */
	public function where($col, $operator, $val) {
		
		if(!$this->is_valid_where_operator($operator)) {
			
			die("ERROR: Invalid where operator '$operator'.\n");
			
		}

		$this->where[] = array(
			'type'=>'column',
			'column'=>$col,
			'operator'=>$operator,
			'value'=>$val
		);
		
		return $this;
		
	}
	
	/**
	 * Start Group
	 * @return $this
	 */
	public function start_group() {
		
		$this->where[] = array('type'=>'start_group');
		return $this;
		
	}
	
	/**
	 * End Group
	 * @return $this
	 */
	public function end_group() {
		
		$this->where[] = array('type'=>'end_group');
		return $this;
		
	}
	
	/**
	 * And Clause
	 * @return $this
	 */
	public function and_clause() {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'AND');
		return $this;
	
	}
	
	/**
	 * Or Clause
	 * @return $this
	 */
	public function or_clause() {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'OR');
		return $this;
	
	}
	
	/**
	 * Where Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function where_null($col) {
	
		$this->where[] = array('type'=>'null', 'column'=>$col);
		return $this;
	
	}
	
	/**
	 * Where Not Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function where_not_null($col) {
	
		$this->where[] = array('type'=>'not_null', 'column'=>$col);
		return $this;
	
	}
	
	/**
	 * And Where
	 * @param string Column to compare
	 * @param string Operator
	 * @param string Value to compare
	 * @return $this
	 */
	public function and_where($col, $operator, $val) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'AND');
		return $this->where($col, $operator, $val);
	
	}
	
	/**
	 * Or Where
	 * @param string Column to compare
	 * @param string Operator
	 * @param string Value to compare
	 * @return $this
	 */
	public function or_where($col, $operator, $val) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'OR');
		return $this->where($col, $operator, $val);
	
	}
	
	/**
	 * And Where Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function and_where_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'AND');
		return $this->where_null($col);
	
	}
	
	/**
	 * Or Where Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function or_where_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'OR');
		return $this->where_null($col);
	
	}
	
	/**
	 * And Where Not Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function and_where_not_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'AND');
		return $this->where_not_null($col);
	
	}
	
	/**
	 * Or Where Not Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function or_where_not_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'OR');
		return $this->where_not_null($col);
	
	}
	
	/**
	 * Order Ascending
	 * @param string Column to order by
	 * @return $this
	 */
	public function order_asc($column) {
	
		$this->order[] = array('column'=>$column, 'direction'=>'ASC');
		return $this;
	
	}
	
	/**
	 * Order Descending
	 * @param string Column to order by
	 * @return $this
	 */
	public function order_desc($column) {
	
		$this->order[] = array('column'=>$column, 'direction'=>'DESC');
		return $this;
	
	}
	
	/**
	 * Limit
	 * @param int Limit
	 * @return $this
	 */
	public function limit($limit) {
	
		if(!preg_match('/^[0-9]+$/', $limit)) {
		
			die('ERROR: Invalid limit.\n');
		
		}
		
		$this->limit = $limit;
		return $this;
	
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public abstract function build();

}