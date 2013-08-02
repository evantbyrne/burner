<?php

namespace Mysql;

/**
 * Point Column
 */
class PointColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` POINT{$this->build_null()}";
	
	}
	
}