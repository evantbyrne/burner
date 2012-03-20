<?php

namespace MySQLBuilder;


/* Base */
abstract class Base {

	protected $table;
	protected $where;
	protected $order;
	protected $limit;
	
	/* Construct */
	public function __construct($table) {
	
		$this->table = $table;
		$this->where = array();
		$this->order = array();
		$this->limit = null;
	
	}
	
	/* Build Where */
	protected function build_where() {
			
		$sql = 'WHERE';
		
		foreach($this->where as $i) {
				
			if($i['type'] == 'column') {
					
				if($i['operator'] == 'LIKE') {
						
					$sql .= " `{$i['column']}` {$i['operator']} '%{$i['value']}'";
						
				} else {
						
					$sql .= " `{$i['column']}` {$i['operator']} '{$i['value']}'";
						
				}
				
			} elseif($i['type'] == 'on') {
					
				$sql .= " `{$i['col1']}` {$i['operator']} `{$i['col2']}`";
					
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
		
			$sql[] = "`{$ord['column']}` {$ord['direction']}";
		
		}
		
		return 'ORDER BY ' . implode(', ', $sql);
	
	}
	
	/* Build Limit */
	protected function build_limit() {
	
		return "LIMIT {$this->limit}";
	
	}
	
	/* Valid Where Operator */
	public function is_valid_where_operator($operator) {
	
		return in_array($operator, array('=', '!=', '<', '>', '<=', '>=', 'LIKE'));
	
	}
	
	/* Add Where */
	public function add_where($col, $operator, $val) {
		
		if(!$this->is_valid_where_operator($operator)) {
			
			die("ERROR: Invalid where operator '$operator'.\n");
			
		}

		$this->where[] = array(
			'type'=>'column',
			'column'=>$col,
			'operator'=>$operator,
			'value'=>$val//$this->table->db->clean($val)
		);
		
	}
	
	/* Add And */
	public function add_and() {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'and');
	
	}
	
	/* Add Or */
	public function add_or() {
	
		$this->where[] = array('type'=>'clause', 'clause'=>'or');
	
	}
	
	/* Add And Where */
	public function add_and_where($col, $operator, $val) {
	
		$this->add_and();
		$this->add_where($col, $operator, $val);
	
	}
	
	/* Add Or Where */
	public function add_or_where($col, $operator, $val) {
	
		$this->add_or();
		$this->add_where($col, $operator, $val);
	
	}
	
	/* Add Order Asc */
	public function add_order_asc($column) {
	
		$this->order[] = array('column'=>$column, 'direction'=>'ASC');
	
	}
	
	/* Add Order Desc */
	public function add_order_desc($column) {
	
		$this->order[] = array('column'=>$column, 'direction'=>'DESC');
	
	}
	
	/* Set Limit */
	public function set_limit($limit) {
	
		if(!preg_match('/^[0-9]+$/', $limit)) {
		
			die('ERROR: Invalid limit.\n');
		
		}
		
		$this->limit = $limit;
	
	}

}


/* Select */
class Select extends Base {
	
	protected $columns;
	protected $offset;
	
	/* Construct */
	public function __construct($table) {
	
		parent::__construct($table);
		$this->columns = array();
		$this->offset = null;
	
	}
	
	/* Build Columns */
	protected function build_columns() {
	
		// Columns
		if(count($this->columns) == 0 or in_array('*', $this->columns)) {
			
			// All
			return '*';
			
		} else {
			
			// Just specified
			return '`' . implode('`, `', $this->columns) . '`';
			
		}
	
	}
	
	/* Build Offset */
	protected function build_offset() {
	
		return "OFFSET {$this->offset}";
	
	}
	
	/* Add Column */
	public function add_column($column) {
	
		$this->columns[] = $column;
	
	}
	
	/* Set Offset */
	public function set_offset($offset) {
	
		if(!preg_match('/^[0-9]+$/', $offset)) {
		
			die('ERROR: Invalid offset.\n');
		
		}
	
		$this->offset = $offset;
	
	}
	
	/* Build */
	public function build() {
	
		$sql = array('SELECT');
		
		// Columns
		$sql[] = $this->build_columns();
		
		// From
		$sql[] = "FROM `{$this->table}`";
		
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
		
		return implode(' ', $sql);
	
	}

}


/* Update */
class Update extends Base {

	protected $values;
	
	/* Construct */
	public function __construct($table) {
	
		parent::__construct($table);
		$this->values = array();
	
	}
	
	/* Add Value */
	public function add_value($column, $value) {
	
		$this->values[$column] = $value;
	
	}
	
	/* Build */
	public function build() {
	
		$sql = array("UPDATE `{$this->table}` SET");
		
		// Values
		if(empty($this->values)) {
		
			die("ERROR: No values specified in update query.\n");
		
		}
		
		$vals = array();
		foreach($this->values as $column=>$value) {
		
			$vals[] = "`$column`='$value'";
		
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
		
		return implode(' ', $sql);
	
	}

}


/* Delete */
class Delete extends Base {
	
	/* Build */
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
		
		return implode(' ', $sql);
	
	}

}


/* Insert */
class Insert {

	protected $table;
	protected $values;
	
	/* Construct */
	public function __construct($table) {
	
		$this->table = $table;
		$this->values = array();
	
	}
	
	/* Add Value */
	public function add_value($column, $value) {
	
		$this->values[$column] = $value;
	
	}
	
	/* Build */
	public function build() {
	
		$sql = array("INSERT INTO `{$this->table}`");
		
		if(count($this->values) > 0) {
		
			// Columns
			$sql[] = '(`' . implode('`, `', array_keys($this->values)) . '`)';
		
			// Values
			$sql[] = "VALUES ('" . implode("', '", array_values($this->values)) . "')";
		
		}
		
		return implode(' ', $sql);
	
	}

}


/* Create Table */
class CreateTable {

	protected $name;
	protected $columns;
	
	/* Construct */
	public function __construct($name) {
	
		$this->name = $name;
		$this->columns = array();
	
	}
	
	/* Add Column */
	public function add_column($column) {
	
		$this->columns[] = $column;
	
	}
	
	/* Build */
	public function build() {
	
		$sql = array("CREATE TABLE {$this->name}(");
		$sql_cols = array();
		
		foreach($this->columns as $column) {
		
			$sql_cols[] = $column->build();
		
		}
		
		$sql[] = implode(",\n", $sql_cols);
		$sql[] = ')';
		return implode("\n", $sql);
	
	}
	
}



/* Table Column */
abstract class TableColumn {

	protected $name;
	protected $options;
	
	/* Construct */
	public function __construct($name, $options=array()) {
	
		$this->name = $name;
		$this->options = $options;
	
	}
	
	/* Add Option */
	public function add_option($key, $value) {
	
		$this->options[$key] = $value;
	
	}
	
	/* Build Null */
	public function build_null() {
	
		// Default to not null
		return (isset($this->options['null']) and $this->options['null'] === true) ? 'NULL' : 'NOT NULL';
	
	}

}

/* Int Column */
class IntColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "{$this->name} {$this->build_null()} INT";
	
	}
	
}

/* Text Column */
class TextColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "{$this->name} {$this->build_null()} TEXT";
	
	}
	
}

/* Varchar Column */
class VarcharColumn extends TableColumn {
	
	/* Build */
	public function build() {
		
		// Max length
		if(!isset($this->options['max_length'])) {
		
			die("ERROR: No varchar character max_length given.\n");
		
		}
		
		return "{$this->name} {$this->build_null()} VARCHAR({$this->options['max_length']})";
	
	}
	
}



/*$s = new Select('Woo');
$s->add_column('one');
$s->add_column('two');
//$s->add_where('one', '=', 'yup');
//$s->add_or_where('two', '!=', 'nope');
//$s->add_order_asc('one');
//$s->add_order_desc('two');
$s->set_limit(10);
$s->set_offset(5);
echo $s->build() . "\n";*/

/*$e = new Update('Woo');
$e->add_value('one', 'foo');
$e->add_value('two', 'bar');
$e->add_where('one', '=', 'yup');
$e->add_order_desc('id');
$e->set_limit(1);
echo $e->build() . "\n";*/

/*$d = new Delete('Woo');
$d->add_where('one', '=', 'yup');
$d->add_or_where('two', '!=', 'nope');
$d->add_order_asc('one');
$d->add_order_desc('two');
$d->set_limit(1);
echo $d->build() . "\n";*/

$t = new CreateTable('User');
$t->add_column(new IntColumn('id'));
$t->add_column(new VarcharColumn('name', array('max_length'=>30)));
echo $t->build() . "\n\n";