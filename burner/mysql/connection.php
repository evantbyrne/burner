<?php

namespace Mysql;

/**
 * Connection Class
 */
class Connection {

	private $connection;
	private $host;
	private $user;
	private $pass;
	private $db;
	private $last_result;
	private $queries;
	
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
		$this->queries = array();
		
		$this->last_result = null;
		
		try {
			
			$this->connection = new \PDO("mysql:dbname={$this->db};host={$this->host}", $this->user, $this->pass);
			$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		} catch(\PDOException $e) {
		
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
	 * @param Query
	 * @param string Class type to use for result object
	 * @return array An array of result objects
	 */
	public function fetch($query, $result_class='Result') {
	
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
		
		if(\Core\Config::get('debug')) {
			
			$this->queries[] = $query;
			
		}
		
		return $this->last_result;
	
	}
	
	/**
	 * Execute
	 * @param Query
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
		
		if(\Core\Config::get('debug')) {
			
			$this->queries[] = $query;
			
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
	 * Queries
	 * @return array
	 */
	public function queries() {
		
		return $this->queries;
		
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
	 * @return Select
	 */
	public function select($table, $result_class = null) {
	
		return new Select($table, $result_class, $this);
	
	}
	
	/**
	 * Delete
	 * @param string Table name
	 * @return Delete
	 */
	public function delete($table) {
	
		return new Delete($table, $this);
	
	}
	
	/**
	 * Update
	 * @param string Table name
	 * @return Update
	 */
	public function update($table) {
	
		return new Update($table, $this);
	
	}
	
	/**
	 * Insert
	 * @param string Table name
	 * @return Insert
	 */
	public function insert($table) {
	
		return new Insert($table, $this);
	
	}
	
	/**
	 * Create Table
	 * @param string Table name
	 * @param boolean Add IF NOT EXISTS clause if true
	 * @return CreateTable
	 */
	public function create_table($table, $if_not_exists = false) {
	
		return new CreateTable($table, $if_not_exists, $this);
	
	}
	
	/**
	 * Drop Table
	 * @param string Table name
	 * @param boolean Add IF EXISTS clause if true
	 * @return mixed Result of query execution
	 */
	public function drop_table($table, $if_exists = false) {
	
		$query = new DropTable($table, $if_exists, $this);
		return $query->execute();
	
	}
	
	/**
	 * Truncate Table
	 * @param string Table name
	 * @return mixed Result of query execution
	 */
	public function truncate_table($table) {
	
		$query = new TruncateTable($table, $this);
		return $query->execute();
	
	}
	
	/**
	 * Rename Table
	 * @param string Table name
	 * @param string New table name
	 * @return mixed Result of query execution
	 */
	public function rename_table($table, $new_name) {
	
		$query = new RenameTable($table, $new_name, $this);
		return $query->execute();
	
	}
	
	/**
	 * Alter Table
	 * @param string Table name
	 * @return AlterTable
	 */
	public function alter_table($table) {
	
		return new AlterTable($table, $this);
	
	}

}