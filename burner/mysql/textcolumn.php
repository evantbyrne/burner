<?php

namespace Mysql;

/**
 * Text Column
 */
class TextColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TEXT{$this->build_null()}";
	
	}
	
}