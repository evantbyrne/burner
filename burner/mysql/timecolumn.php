<?php

namespace Mysql;

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