<?php

namespace Mysql;

/**
 * Int Column
 */
class IntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` INT{$this->build_null()}";
	
	}
	
}