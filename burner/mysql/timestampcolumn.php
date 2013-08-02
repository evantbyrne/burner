<?php

namespace Mysql;

/**
 * Timestamp Column
 */
class TimestampColumn extends TableColumn {
	
	/**
	 * @return string DEFAULT portion of SQL
	 */
	protected function build_default() {
		
		$null = $this->build_null();
		
		if($null === ' NULL') {
			
			return $null;
			
		}
		
		return ' DEFAULT CURRENT_TIMESTAMP';
		
	}
	
	/**
	 * @return string ON UPDATE portion of SQL
	 */
	protected function build_on() {
		
		return (isset($this->options['auto_update']) and $this->options['auto_update'] === true) ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
		
	}
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` TIMESTAMP{$this->build_default()}{$this->build_on()}";
	
	}
	
}