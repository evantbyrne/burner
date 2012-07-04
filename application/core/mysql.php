<?php

/**
 * MySQL Query Builder Library
 * @author Beaker Studio http://codecanyon.net/user/Beaker_Studio
 */

namespace Mysql;



/**
 * Mysql Connection Class
 * @author Beaker Studio
 */
class Connection {

	private $connection;
	private $host;
	private $user;
	private $pass;
	private $db;
	private $last_result;
	
	/**
	 * Construct
	 * @param string Host
	 * @param string Database
	 * @param string User
	 * @param string Password
	 */
	public function __construct($host='', $db='', $user='', $pass='') {
	
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;
		
		$this->last_result = null;
		
		try {
			
			$this->connection = new PDO("mysql:dbname={$this->db};host={$this->host}", $this->user, $this->pass);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		} catch(PDOException $e) {
		
			throw new Exception($e->getMessage());
		
		}
	
	}
	
	/**
	 * Destruct
	 *
	 * Closes the database connection
	 */
	public function __destruct() {
	
		$this->close_connection();
	
	}
	
	/**
	 * Close Connection
	 */
	public function close_connection() {
		
		$this->connection = null;
		
	}
	
	/**
	 * Clean
	 *
	 * Cleans a value
	 * @param string Value to be cleaned
	 * @return string Cleaned value
	 */
	public function clean($value) {
	
		return substr($this->connection->quote($value),1,-1);
	
	}
	
	/**
	 * Quote
	 *
	 * Cleans and quotes a value
	 * @param string Value to be cleaned and quoted
	 * @return string Cleaned and quoted value
	 */
	public function quote($value) {
	
		return $this->connection->quote($value);
	
	}
	
	/**
	 * Fetch
	 * @param MysqlQuery Query to execute
	 * @param string Class type to use for result object
	 * @return array An array of result objects
	 */
	public function fetch($query, $result_class='MysqlResult') {
	
		$sql = $query->sql();
		$params = $query->params();
		
		if(preg_match('/^SELECT/is', $sql)) {
		
			$res = $this->connection->prepare($sql);
			
			// Bind values
			foreach($params as $i=>$value) {
			
				$res->bindValue($i+1, $value);
			
			}
			
			$res->setFetchMode(\PDO::FETCH_CLASS, $result_class);
			$res->execute();
			$this->last_result = $res->fetchAll();
		
		} else {
		
			throw new Exception('MySQL Query: Non SELECT query used with fetch method.');
		
		}
		
		return $this->last_result;
	
	}
	
	/**
	 * Execute
	 * @param MysqlQuery Query to execute
	 * @return mixed Result of query
	 */
	public function execute($query) {
	
		$sql = $query->sql();
		$params = $query->params();
	
		// Select query
		if(preg_match('/^SELECT/is', $sql)) {
		
			throw new Exception('MySQL Query: SELECT query used with execute method.');
		
		} else {
		
			$res = $this->connection->prepare($sql);
			
			// Bind values
			foreach($params as $i=>$value) {
			
				$res->bindValue($i+1, $value);
			
			}
			
			$this->last_result = $res->execute();
		
		}
		
		return $this->last_result;
	
	}
	
	/**
	 * Start Transaction
	 */
	public function start_transaction() {
		
		$this->connection->beginTransaction();
		
	}
	
	/**
	 * Commit Transaction
	 */
	public function commit_transaction() {
		
		$this->connection->commit();
		
	}
	
	/**
	 * Rollback Transaction
	 */
	public function rollback_transaction() {
		
		$this->connection->rollBack();
		
	}
	
	/**
	 * Last Insert ID
	 * @return int ID of last inserted row
	 */
	public function last_insert_id() {
		
		return $this->connection->lastInsertId();
		
	}
	
	/**
	 * Get PDO Connection
	 * @return PDO The PDO connection
	 */
	public function get_pdo_connection() {
		
		return $this->connection;
		
	}
	
	/**
	 * Set PDO Connection
	 * @param PDO A PDO connection
	 */
	public function set_pdo_connection($pdo_connection) {
		
		if(get_class($pdo_connection) == 'PDO' or is_subclass_of($pdo_connection, 'PDO')) {
		
			$this->connection = $pdo_connection;
		
		} else {
			
			throw new Exception('MySQL Query: Non-PDO connection given.');
			
		}
		
	}
	
	/**
	 * Select
	 * @param string Table name
	 * @return MysqlSelect
	 */
	public function select($table) {
	
		return new MysqlSelect($table, $this);
	
	}
	
	/**
	 * Delete
	 * @param string Table name
	 * @return MysqlDelete
	 */
	public function delete($table) {
	
		return new MysqlDelete($table, $this);
	
	}
	
	/**
	 * Update
	 * @param string Table name
	 * @return MysqlUpdate
	 */
	public function update($table) {
	
		return new MysqlUpdate($table, $this);
	
	}
	
	/**
	 * Insert
	 * @param string Table name
	 * @param mixed[] Values to insert
	 * @return int Last insert ID
	 */
	public function insert($table, $values) {
	
		$query = new MysqlInsert($table, $this);
		
		foreach($values as $column => $value) {
		
			$query->value($column, $value);
		
		}
		
		return $query->execute();
	
	}
	
	/**
	 * Create Table
	 * @param string Table name
	 * @param boolean Add IF NOT EXISTS clause if true
	 * @return MysqlCreateTable
	 */
	public function create_table($table, $if_not_exists = false) {
	
		return new MysqlCreateTable($table, $if_not_exists, $this);
	
	}
	
	/**
	 * Drop Table
	 * @param string Table name
	 * @param boolean Add IF EXISTS clause if true
	 * @return mixed Result of query execution
	 */
	public function drop_table($table, $if_exists = false) {
	
		$query = new MysqlDropTable($table, $if_exists, $this);
		return $query->execute();
	
	}
	
	/**
	 * Truncate Table
	 * @param string Table name
	 * @return mixed Result of query execution
	 */
	public function truncate_table($table) {
	
		$query = new MysqlTruncateTable($table, $this);
		return $query->execute();
	
	}
	
	/**
	 * Rename Table
	 * @param string Table name
	 * @param string New table name
	 * @return mixed Result of query execution
	 */
	public function rename_table($table, $new_name) {
	
		$query = new MysqlRenameTable($table, $new_name, $this);
		return $query->execute();
	
	}
	
	/**
	 * Alter Table
	 * @param string Table name
	 * @return MysqlAlterTable
	 */
	public function alter_table($table) {
	
		return new MysqlAlterTable($table, $this);
	
	}

}

/**
 * Result Class
 * @author Beaker Studio
 */
class Result {

}

/**
 * Abstract Mysql Base
 * @author Beaker Studio
 */
abstract class Base {

	protected $connection;
	protected $params;
	
	/**
	 * Construct
	 * @param MysqlConnection
	 */
	public function __construct($connection = null) {
	
		$this->connection = $connection;
		$this->params = array();
	
	}
	
	/**
	 * Add Param
	 * @param mixed Param to add
	 * @return $this
	 */
	protected function add_param($param) {
	
		$this->params[] = $param;
		return $this;
	
	}
	
	/**
	 * Params
	 * @return array Params
	 */
	public function params() {
	
		return $this->params;
	
	}

}

/**
 * Abstract Mysql Where Base Class
 * @author Beaker Studio
 */
abstract class WhereBase extends Base {

	protected $table;
	protected $where;
	protected $order;
	protected $limit;
	
	/**
	 * Construct
	 * @param string Table
	 * @param MysqlConnection
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
		
			$sql[] = "{$this->tick_columm($ord['column'])} {$ord['direction']}";
		
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
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
		return $this;
	
	}
	
	/**
	 * Or Clause
	 * @return $this
	 */
	public function or_clause() {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
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
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
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
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
		return $this->where($col, $operator, $val);
	
	}
	
	/**
	 * And Where Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function and_where_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
		return $this->where_null($col);
	
	}
	
	/**
	 * Or Where Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function or_where_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
		return $this->where_null($col);
	
	}
	
	/**
	 * And Where Not Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function and_where_not_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
		return $this->where_not_null($col);
	
	}
	
	/**
	 * Or Where Not Null
	 * @param string Column to compare
	 * @return $this
	 */
	public function or_where_not_null($col) {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
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
	 * @return MysqlQuery
	 */
	public abstract function build();

}



/**
 * Mysql Query Class
 * @author Beaker Studio
 */
class Query {

	protected $sql;
	protected $params;
	
	/**
	 * Construct
	 * @param string SQL
	 * @param array Params to be inserted into SQL
	 */
	public function __construct($sql, $params=array()) {
	
		$this->sql = $sql;
		$this->params = $params;
	
	}
	
	/**
	 * SQL
	 * @return string SQL
	 */
	public function sql() {
	
		return $this->sql;
	
	}
	
	/**
	 * Params
	 * @return array Params
	 */
	public function params() {
	
		return $this->params;
	
	}

}

/**
 * Mysql Select
 * @author Beaker Studio
 */
class Select extends WhereBase {
	
	protected $columns;
	protected $joins;
	protected $offset;
	
	/**
	 * Construct
	 * @param string Table
	 * @param MysqlConnection
	 */
	public function __construct($table, $connection = null) {
	
		parent::__construct($table, $connection);
		$this->columns = array();
		$this->joins = array();
		$this->offset = null;
	
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
		$last = end(explode('.', $column));
		
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
	 * Build
	 * @return MysqlQuery
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
	 * @param string Type of object to return
	 * @return array Objects of type set in first param
	 */
	public function fetch($result_class = '\Mysql\Result') {
	
		if(isset($this->connection)) {
		
			return $this->connection->fetch($this->build(), $result_class);
		
		}
	
	}

}

/**
 * Mysql Update
 * @author Beaker Studio
 */
class Update extends WhereBase {

	protected $values;
	
	/**
	 * Construct
	 * @param string Table
	 * @param MysqlConnection
	 */
	public function __construct($table, $connection = null) {
	
		parent::__construct($table, $connection);
		$this->values = array();
	
	}
	
	/**
	 * @param string Column to update
	 * @param string Value, which may be NULL
	 * @return $this
	 */
	public function value($column, $value=null) {
	
		$this->values[$column] = $value;
		return $this;
	
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		$sql = array("UPDATE `{$this->table}` SET");
		
		// Values
		if(empty($this->values)) {
		
			die("ERROR: No values specified in update query.\n");
		
		}
		
		$vals = array();
		foreach($this->values as $column=>$value) {
		
			if($value === null) {
			
				$vals[] = "{$this->tick_column($column)} = NULL";
			
			} else {
			
				$vals[] = "{$this->tick_column($column)} = ?";
				$this->add_param($value);
				
			}
		
		}
		
		$sql[] = implode(', ', $vals);
		
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
		
		return new Query(implode(' ', $sql), $this->params());
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of database query
	 */
	public function execute() {
	
		if(isset($this->connection)) {
		
			return $this->connection->execute($this->build());
		
		}
	
	}

}

/**
 * Mysql Delete
 * @author Beaker Studio
 */
class Delete extends WhereBase {
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		$sql = array("DELETE FROM `{$this->table}`");
		
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
		
		return new Query(implode(' ', $sql), $this->params());
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
	
		if(isset($this->connection)) {
		
			return $this->connection->execute($this->build());
		
		}
	
	}

}

/**
 * Mysql Insert
 * @author Beaker Studio
 */
class Insert extends Base {

	protected $table;
	protected $values;
	
	/**
	 * Construct
	 * @param string Table
	 * @param MysqlConnection
	 */
	public function __construct($table, $connection = null) {
	
		parent::__construct($connection);
		$this->table = $table;
		$this->values = array();
	
	}
	
	/**
	 * Value
	 * @param string Column
	 * @param string Value
	 */
	public function value($column, $value) {
	
		$this->values[$column] = $value;
		$this->add_param($value);
		return $this;
	
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		$sql = array("INSERT INTO `{$this->table}`");
		
		if(count($this->values) > 0) {
		
			// Columns
			$sql[] = '(`' . implode('`, `', array_keys($this->values)) . '`)';
		
			// Values
			$vals = array();
			for($i = 0; $i < count($this->values); $i++) {
			
				$vals[] = '?';
			
			}
			
			$sql[] = 'VALUES (' . implode(', ', $vals) . ')';
		
		}
		
		return new Query(implode(' ', $sql), $this->params());
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of database query
	 */
	public function execute() {
	
		if(isset($this->connection)) {
		
			$this->connection->execute($this->build());
			return $this->connection->last_insert_id();
		
		}
	
	}

}

/**
 * Mysql Create Table
 * @author Beaker Studio
 */
class CreateTable {

	protected $table;
	protected $additions;
	protected $engine;
	protected $id_not_exists;
	protected $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param boolean If true, then add IF NOT EXISTS clause
	 * @param MysqlConnection
	 */
	public function __construct($table, $if_not_exists = false, $connection = null) {
	
		$this->table = $table;
		$this->additions = array();
		$this->engine = null;
		$this->if_not_exists = $if_not_exists;
		$this->connection = $connection;
	
	}
	
	/**
	 * @param mixed Table addition
	 * @return $this
	 */
	public function add($addition) {
	
		$this->additions[] = $addition;
		return $this;
	
	}
	
	/**
	 * Engine
	 * @param string MySQL table engine
	 * @return $this
	 */
	public function engine($engine) {
	
		$this->engine = $engine;
		return $this;
	
	}
	
	/**
	 * If Not Exists
	 * 
	 * Adds IF NOT EXISTS clause
	 * @return $this
	 */
	public function if_not_exists() {
		
		$this->if_not_exists = true;
		return $this;
		
	}
	
	/**
	 * Build If Not Exists
	 * @return string IF NOT EXISTS portion of SQL query
	 */
	protected function build_if_not_exists() {
		
		return ($this->if_not_exists) ? ' IF NOT EXISTS' : '';
		
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		$sql = array("CREATE TABLE{$this->build_if_not_exists()} `{$this->table}`(");
		$sql_cols = array();
		
		// Additions (Columns, Keys, Indexes)
		foreach($this->additions as $addition) {
		
			$sql_cols[] = $addition->build();
		
		}
		
		$sql[] = implode(",\n", $sql_cols);
		
		// Engine
		$sql[] = ($this->engine === null) ? ')' : ") ENGINE = {$this->engine}";
		
		return new Query(implode("\n", $sql));
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}



/**
 * Mysql Drop Table
 * @author Beaker Studio
 */
class DropTable {
	
	private $table;
	private $if_exists;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param boolean If true, then add IF EXISTS clause
	 * @param MysqlConnection
	 */
	public function __construct($table, $if_exists = false, $connection = null) {
	
		$this->table = $table;
		$this->if_exists = $if_exists;
		$this->connection = $connection;
	
	}
	
	/**
	 * If Exists
	 *
	 * Adds IF EXISTS clause
	 * @return $this
	 */
	public function if_exists() {
		
		$this->if_exists = true;
		return $this;
		
	}
	
	/**
	 * Build If Exists
	 * @return string IF NOT EXISTS portion of SQL query
	 */
	protected function build_if_exists() {
		
		return ($this->if_exists) ? ' IF EXISTS' : '';
		
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		return new Query("DROP TABLE{$this->build_if_exists()} `{$this->table}`");
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}



/**
 * Mysql Truncate Table
 * @author Beaker Studio
 */
class TruncateTable {
	
	private $table;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param MysqlConnection
	 */
	public function __construct($table, $connection = null) {
	
		$this->table = $table;
		$this->connection = $connection;
	
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		return new Query("TRUNCATE TABLE `{$this->table}`");
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}



/**
 * Mysql Rename Table
 * @author Beaker Studio
 */
class RenameTable {
	
	private $table;
	private $new_name;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param string New name for table
	 * @param MysqlConnection
	 */
	public function __construct($table, $new_name, $connection = null) {
	
		$this->table = $table;
		$this->new_name = $new_name;
		$this->connection = $connection;
	
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		return new Query("ALTER TABLE `{$this->table}` RENAME `{$this->new_name}`");
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}



/**
 * Mysql Alter Table
 * @author Beaker Studio
 */
class AlterTable {
	
	private $table;
	private $operations;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param MysqlConnection
	 */
	public function __construct($table, $connection = null) {
	
		$this->table = $table;
		$this->operations = array();
		$this->connection = $connection;
	
	}
	
	/**
	 * Add
	 * @param mixed TableColumn object
	 * @return $this
	 */
	public function add($column) {
	
		$this->operations[] = array('add', $column);
		return $this;
	
	}
	
	/**
	 * Drop
	 * @param string Column name
	 * @return $this
	 */
	public function drop($column_name) {
	
		$this->operations[] = array('drop', $column_name);
		return $this;
	
	}
	
	/**
	 * Modify
	 * @param mixed TableColumn object
	 * @return $this
	 */
	public function modify($column) {
	
		$this->operations[] = array('modify', $column);
		return $this;
	
	}
	
	/**
	 * Build
	 * @return MysqlQuery
	 */
	public function build() {
	
		$sql = array();
		
		// Operations
		foreach($this->operations as $o) {
		
			// Add
			if($o[0] === 'add') {
			
				$sql[] = "ADD {$o[1]->build()}";
			
			// Drop
			} elseif($o[0] === 'drop') {
			
				$sql[] = "DROP COLUMN `{$o[1]}`";
			
			// Modify
			} elseif($o[0] === 'modify') {
			
				$sql[] = "MODIFY {$o[1]->build()}";
			
			}
		
		}
		
		return new Query("ALTER TABLE `{$this->table}` " . implode(', ', $sql));
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}



/**
 * Abstract Table Column
 * @author Beaker Studio
 */
abstract class TableColumn {

	protected $name;
	protected $options;
	
	/**
	 * Construct
	 * @param string Table
	 * @param array Options
	 */
	public function __construct($name, $options=array()) {
	
		$this->name = $name;
		$this->options = $options;
	
	}
	
	/**
	 * Option
	 * @param string Key
	 * @param mixed Value
	 * @return $this
	 */
	public function option($key, $value) {
	
		$this->options[$key] = $value;
		return $this;
	
	}
	
	/**
	 * Build Null
	 * @return string NULL portion of SQL query
	 */
	public function build_null() {
	
		// Nothing, NULL, or NOT NULL
		return (isset($this->options['null'])) ? (($this->options['null'] === true) ? ' NULL' : ' NOT NULL') : '';
	
	}
	
	/**
	 * Build
	 * @return string Column portion of SQL query
	 */
	public abstract function build();

}



/**
 * Int Column
 * @author Beaker Studio
 */
class IntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` INT {$this->build_null()}";
	
	}
	
}



/**
 * Tiny Int Column
 * @author Beaker Studio
 */
class TinyIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TINYINT {$this->build_null()}";
	
	}
	
}



/**
 * Small Int Column
 * @author Beaker Studio
 */
class SmallIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` SMALLINT{$this->build_null()}";
	
	}
	
}



/**
 * Medium Int Column
 * @author Beaker Studio
 */
class MediumIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` MEDIUMINT{$this->build_null()}";
	
	}
	
}



/**
 * Big Int Column
 * @author Beaker Studio
 */
class BigIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` BIGINT{$this->build_null()}";
	
	}
	
}



/**
 * Boolean Column
 * @author Beaker Studio
 */
class BooleanColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` BOOLEAN{$this->build_null()}";
	
	}
	
}



/**
 * Decimal Column
 * @author Beaker Studio
 */
class DecimalColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		// Max
		if(!isset($this->options['max'])) {
		
			die("ERROR: No decimal max given.\n");
		
		}
		
		// Digits
		if(!isset($this->options['digits'])) {
		
			die("ERROR: No decimal digits given.\n");
		
		}
		
		// Max range
		if($this->options['max'] > 65 or $this->options['max'] < 1) {
		
			die("ERROR: Bag decimal max range given. Must be between 1 and 65.\n");
		
		}
		
		// Digits range
		if($this->options['digits'] > 30 or $this->options['digits'] < 0) {
		
			die("ERROR: Bag decimal max range given. Must be between 0 and 30.\n");
		
		}
		
		return "`{$this->name}` Decimal({$this->options['max']}, {$this->options['digits']}){$this->build_null()}";
	
	}
	
}



/**
 * Date Column
 */
class DateColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` DATE{$this->build_null()}";
	
	}
	
}



/**
 * Time Column
 */
class TimeColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TIME{$this->build_null()}";
	
	}
	
}



/**
 * Timestamp Column
 * @author Beaker Studio
 */
class TimestampColumn extends TableColumn {
	
	/**
	 * @return string DEFAULT portion of SQL
	 */
	protected function build_default() {
		
		$null = $this->build_null();
		
		if($null === ' NULL') {
			
			return $null;
			
		}
		
		return ' DEFAULT CURRENT_TIMESTAMP';
		
	}
	
	/**
	 * @return string ON UPDATE portion of SQL
	 */
	protected function build_on() {
		
		return (isset($this->options['auto_update']) and $this->options['auto_update'] === true) ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
		
	}
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TIMESTAMP{$this->build_default()}{$this->build_on()}";
	
	}
	
}



/**
 * Text Column
 * @author Beaker Studio
 */
class TextColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TEXT{$this->build_null()}";
	
	}
	
}



/**
 * Char Column
 * @author Beaker Studio
 */
class CharColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		// Max length
		if(!isset($this->options['length'])) {
		
			die("ERROR: No char length given.\n");
		
		}
		
		return "`{$this->name}` CHAR({$this->options['length']}){$this->build_null()}";
	
	}
	
}



/**
 * Varchar Column
 * @author Beaker Studio
 */
class VarcharColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		// Max length
		if(!isset($this->options['length'])) {
		
			die("ERROR: No varchar length given.\n");
		
		}
		
		return "`{$this->name}` VARCHAR({$this->options['length']}){$this->build_null()}";
	
	}
	
}



/**
 * Enum Column
 * @author Beaker Studio
 */
class EnumColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		// Values
		if(empty($this->options)) {
		
			die("ERROR: No ENUM values given.\n");
		
		}
		
		return "`{$this->name}` ENUM('" . implode("', '", $this->options) . "'){$this->build_null()}";
	
	}
	
}



/**
 * Incrementing Column
 * @author Beaker Studio
 */
class IncrementingColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` INT NOT NULL AUTO_INCREMENT";
	
	}
	
}



/**
 * Abstract Table Addition
 * @author Beaker Studio
 */
abstract class TableAddition {

	protected $values;
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		$this->values = func_get_args();
	
	}
	
	/**
	 * Build
	 * @return String representing addition portion of SQL query
	 */
	public abstract function build();

}



/**
 * Primary Key
 * @author Beaker Studio
 */
class PrimaryKey extends TableAddition {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for primary key.\n");
			
		}
		
		return 'PRIMARY KEY(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}



/**
 * Unique Key
 * @author Beaker Studio
 */
class UniqueKey extends TableAddition {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for unique key.\n");
			
		}
		
		return 'UNIQUE KEY(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}



/**
 * Fulltext Index
 * @author Beaker Studio
 */
class FulltextIndex extends TableAddition {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for FULLTEXT index.\n");
			
		}
		
		return 'FULLTEXT(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}
