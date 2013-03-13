<?php

namespace Column;

/**
 * Order Column
 * @author Evan Byrne
 */
class Order extends Base {
	
	/**
	 * @inheritdoc
	 */
	public function __construct($column_name, $options = array()) {
		
		$options = array_merge(array('template' => 'order', 'list_template' => 'order'), $options);
		parent::__construct($column_name, $options, new \Mysql\IntColumn($column_name, $options));
	
	}

	/**
	 * @inheritdoc
	 */
	public function finalize($model) {

		$name = $this->column_name();
		if(empty($model->{$name})) {

			$model->{$name} = $model->id;
			$model->save();

		}

	}

}