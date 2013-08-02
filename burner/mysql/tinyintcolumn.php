<?php

namespace Mysql;

/**
 * Tiny Int Column
 */
class TinyIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TINYINT{$this->build_null()}";
	
	}
	
}