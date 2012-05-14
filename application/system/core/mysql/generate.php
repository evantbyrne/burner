<?php

namespace Mysql\Generate;

include_once('generate-select.php');
include_once('generate-insert.php');
include_once('generate-update.php');
include_once('generate-delete.php');
include_once('generate-table.php');


/* Base */
abstract class Base {

	protected $params;
	
	/* Construct */
	public function __construct() {
	
		$this->params = array();
	
	}
	
	/* Add Param */
	protected function add_param($param) {
	
		$this->params[] = $param;
		return $this;
	
	}
	
	/* Params */
	public function params() {
	
		return $this->params;
	
	}

}


/* Where */
abstract class WhereBase extends Base {

	protected $table;
	protected $where;
	protected $order;
	protected $limit;
	
	/* Construct */
	public function __construct($table) {
	
		parent::__construct();
		$this->table = $table;
		$this->where = array();
		$this->order = array();
		$this->limit = null;
	
	}
	
	/* Tick Column */
	protected function tick_column($column) {
		
		$parts = explode('.', $column);
		for($i = 0; $i < count($parts); $i++) {
		
			$parts[$i] = "`{$parts[$i]}`";
		
		}
		
		return implode('.', $parts);
		
	}
	
	/* Build Where */
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
	
	/* Build Order */
	protected function build_order() {
	
		$sql = array();
		
		foreach($this->order as $ord) {
		
			$sql[] = "{$this->tick_columm($ord['column'])} {$ord['direction']}";
		
		}
		
		return 'ORDER BY ' . implode(', ', $sql);
	
	}
	
	/* Build Limit */
	protected function build_limit() {
	
		return "LIMIT {$this->limit}";
	
	}
	
	/* Valid Where Operator */
	protected function is_valid_where_operator($operator) {
	
		return in_array($operator, array('=', '!=', '<', '>', '<=', '>=', 'LIKE', 'MATCH', 'MATCH_BOOLEAN'));
	
	}
	
	/* Add Where */
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
	
	/* Start Where Group */
	public function start_group() {
		
		$this->where[] = array('type'=>'start_group');
		return $this;
		
	}
	
	/* End Where Group */
	public function end_group() {
		
		$this->where[] = array('type'=>'end_group');
		return $this;
		
	}
	
	/* Where Null */
	public function where_null($col) {
	
		$this->where[] = array('type'=>'null', 'column'=>$col);
		return $this;
	
	}
	
	/* Where Not Null */
	public function where_not_null($col) {
	
		$this->where[] = array('type'=>'not_null', 'column'=>$col);
		return $this;
	
	}
	
	/* And Where */
	public function and_where($col, $operator, $val) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
		return $this->where($col, $operator, $val);
	
	}
	
	/* Or Where */
	public function or_where($col, $operator, $val) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
		return $this->where($col, $operator, $val);
	
	}
	
	/* And Where Null */
	public function and_where_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
		return $this->where_null($col);
	
	}
	
	/* Or Where Null */
	public function or_where_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
		return $this->where_null($col);
	
	}
	
	/* And Where Not Null */
	public function and_where_not_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
		return $this->where_not_null($col);
	
	}
	
	/* Or Where Not Null */
	public function or_where_not_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
		return $this->where_not_null($col);
	
	}
	
	/* Add Order Asc */
	public function order_asc($column) {
	
		$this->order[] = array('column'=>$column, 'direction'=>'ASC');
		return $this;
	
	}
	
	/* Add Order Desc */
	public function order_desc($column) {
	
		$this->order[] = array('column'=>$column, 'direction'=>'DESC');
		return $this;
	
	}
	
	/* Set Limit */
	public function limit($limit) {
	
		if(!preg_match('/^[0-9]+$/', $limit)) {
		
			die('ERROR: Invalid limit.\n');
		
		}
		
		$this->limit = $limit;
		return $this;
	
	}
	
	/* Build */
	public abstract function build();

}


/* Query */
class Query {

	protected $sql;
	protected $params;
	
	/* Construct */
	public function __construct($sql, $params=array()) {
	
		$this->sql = $sql;
		$this->params = $params;
	
	}
	
	/* SQL */
	public function sql() {
	
		return $this->sql;
	
	}
	
	/* Params */
	public function params() {
	
		return $this->params;
	
	}

}