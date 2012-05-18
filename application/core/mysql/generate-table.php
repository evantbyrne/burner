<?php

namespace Mysql\Generate;


/* Create Table */
class CreateTable {

	protected $table;
	protected $additions;
	protected $engine;
	
	/* Construct */
	public function __construct($table) {
	
		$this->table = $table;
		$this->additions = array();
		$this->engine = null;
	
	}
	
	/* Add */
	public function add($addition) {
	
		$this->additions[] = $addition;
		return $this;
	
	}
	
	/* Set Engine */
	public function engine($engine) {
	
		$this->engine = $engine;
		return $this;
	
	}
	
	/* Build */
	public function build() {
	
		$sql = array("CREATE TABLE `{$this->table}`(");
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
	public function option($key, $value) {
	
		$this->options[$key] = $value;
		return $this;
	
	}
	
	/* Build Null */
	public function build_null() {
	
		// Nothing, NULL, or NOT NULL
		return (isset($this->options['null'])) ? (($this->options['null'] === true) ? ' NULL' : ' NOT NULL') : '';
	
	}
	
	/* Build */
	public abstract function build();

}

/* Int Column */
class IntColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` INT {$this->build_null()}";
	
	}
	
}

/* Tiny Int Column */
class TinyIntColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` TINYINT {$this->build_null()}";
	
	}
	
}

/* Small Int Column */
class SmallIntColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` SMALLINT{$this->build_null()}";
	
	}
	
}

/* Medium Int Column */
class MediumIntColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` MEDIUMINT{$this->build_null()}";
	
	}
	
}

/* Big Int Column */
class BigIntColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` BIGINT{$this->build_null()}";
	
	}
	
}

/* Boolean Column */
class BooleanColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` BOOLEAN{$this->build_null()}";
	
	}
	
}

/* Decimal Column */
class DecimalColumn extends TableColumn {
	
	/* Build */
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

/* Text Column */
class TextColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` TEXT{$this->build_null()}";
	
	}
	
}

/* Varchar Column */
class CharColumn extends TableColumn {
	
	/* Build */
	public function build() {
		
		// Max length
		if(!isset($this->options['length'])) {
		
			die("ERROR: No char length given.\n");
		
		}
		
		return "`{$this->name}` CHAR({$this->options['length']}){$this->build_null()}";
	
	}
	
}

/* Varchar Column */
class VarcharColumn extends TableColumn {
	
	/* Build */
	public function build() {
		
		// Max length
		if(!isset($this->options['length'])) {
		
			die("ERROR: No varchar length given.\n");
		
		}
		
		return "`{$this->name}` VARCHAR({$this->options['length']}){$this->build_null()}";
	
	}
	
}

/* Enum Column */
class EnumColumn extends TableColumn {
	
	/* Build */
	public function build() {
		
		// Values
		if(empty($this->options)) {
		
			die("ERROR: No ENUM values given.\n");
		
		}
		
		return "`{$this->name}` ENUM('" . implode("', '", $this->options) . "'){$this->build_null()}";
	
	}
	
}

/* Incrementing Column */
class IncrementingColumn extends TableColumn {
	
	/* Build */
	public function build() {
	
		return "`{$this->name}` INT NOT NULL AUTO_INCREMENT";
	
	}
	
}



/* Table Key */
abstract class TableAddition {

	protected $values;
	
	/* Construct */
	public function __construct() {
	
		$this->values = func_get_args();
	
	}
	
	/* Build */
	public abstract function build();

}

/* Primary Key */
class PrimaryKey extends TableAddition {
	
	/* Build */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for primary key.\n");
			
		}
		
		return 'PRIMARY KEY(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}

/* Unique Key */
class UniqueKey extends TableAddition {
	
	/* Build */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for unique key.\n");
			
		}
		
		return 'UNIQUE KEY(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}

/* FulltextIndex */
class FulltextIndex extends TableAddition {
	
	/* Build */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for FULLTEXT index.\n");
			
		}
		
		return 'FULLTEXT(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}



/* Drop Table */
class DropTable {
	
	private $table;
	
	/* Construct */
	public function __construct($table) {
	
		$this->table = $table;
	
	}
	
	/* Build */
	public function build() {
	
		return new Query("DROP TABLE `{$this->table}`");
	
	}
	
}

/* Truncate Table */
class TruncateTable {
	
	private $table;
	
	/* Construct */
	public function __construct($table) {
	
		$this->table = $table;
	
	}
	
	/* Build */
	public function build() {
	
		return new Query("TRUNCATE TABLE `{$this->table}`");
	
	}
	
}

/* Rename Table */
class RenameTable {
	
	private $table;
	private $new_name;
	
	/* Construct */
	public function __construct($table, $new_name) {
	
		$this->table = $table;
		$this->new_name = $new_name;
	
	}
	
	/* Build */
	public function build() {
	
		return new Query("ALTER TABLE `{$this->table}` RENAME `{$this->new_name}`");
	
	}
	
}

/* Alter Table */
class AlterTable {
	
	private $table;
	private $operations;
	
	/* Construct */
	public function __construct($table) {
	
		$this->table = $table;
		$this->operations = array();
	
	}
	
	/* Add */
	public function add($column) {
	
		$this->operations[] = array('add', $column);
		return $this;
	
	}
	
	/* Drop */
	public function drop($column_name) {
	
		$this->operations[] = array('drop', $column_name);
		return $this;
	
	}
	
	/* Modify */
	public function modify($column) {
	
		$this->operations[] = array('modify', $column);
		return $this;
	
	}
	
	/* Build */
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
	
}