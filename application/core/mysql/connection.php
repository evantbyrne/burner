<?php

namespace Mysql;

/**
 * Connection Class
 * @author Evan Byrne
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
	 * @param Host
	 * @param Database
	 * @param User
	 * @param Password
	 */
	public function __construct($host='', $db='', $user='', $pass='') {
	
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;
		
		$this->last_result = null;
	
	}
	
	/**
	 * Close
	 */
	public function __destruct() {
	
		$this->close();
	
	}
	
	/**
	 * Connect
	 */
	public function connect() {
	
		try {
			
			$this->connection = new \PDO("mysql:dbname={$this->db};host={$this->host}", $this->user, $this->pass);
			$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		} catch(\PDOException $e) {
		
			throw new Exception($e->getMessage());
		
		}
	
	}
	
	/* *
	 * Close
	 */
	public function close() {
		
		$this->connection = null;
		
	}
	
	/**
	 * Clean
	 * @param String to be cleaned
	 * @return Cleaned string
	 */
	public function clean($value) {
	
		return substr($this->connection->quote($value),1,-1);
	
	}
	
	/**
	 * Quote
	 * @param String to be cleaned and quoted
	 * @return Cleaned and quoted string
	 */
	public function quote($value) {
	
		return $this->connection->quote($value);
	
	}
	
	/**
	 * Fetch
	 * @param Query object
	 * @param Class type to use for result object
	 * @return An array of result objects
	 */
	public function fetch($query, $result_class='Mysql\Result') {
	
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
	 * @param Query object
	 * @return Result of query
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
	 * @return ID of last inserted row
	 */
	public function last_insert_id() {
		
		return $this->connection->lastInsertId();
		
	}
	
	/**
	 * Get PDO Connection
	 * @return The PDO object
	 */
	public function get_pdo_connection() {
		
		return $this->connection;
		
	}
	
	/*
	 * Set PDO Connection
	 * @param A PDO object
	 */
	public function set_pdo_connection($pdo_connection) {
		
		if(get_class($pdo_connection) == 'PDO' or is_subclass_of($pdo_connection, 'PDO')) {
		
			$this->connection = $pdo_connection;
		
		} else {
			
			throw new Exception('MySQL Query: Non-PDO connection given.');
			
		}
		
	}

}

/**
 * Result Class
 * @author Evan Byrne
 */
class Result {

}

/**
 * Exception Class
 * @author Evan Byrne
 */
class Exception extends \Exception {

}