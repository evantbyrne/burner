<?php

namespace Mysql;

/**
 * Incrementing Column
 */
class IncrementingColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` INT NOT NULL AUTO_INCREMENT";
	
	}
	
}