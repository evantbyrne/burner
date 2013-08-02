<?php

namespace Mysql;

/**
 * Medium Int Column
 */
class MediumIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` MEDIUMINT{$this->build_null()}";
	
	}
	
}