<?php

namespace Mysql;

/**
 * Boolean Column
 */
class BooleanColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` BOOLEAN{$this->build_null()}";
	
	}
	
}