<?php

namespace Mysql;

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