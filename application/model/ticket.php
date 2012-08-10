<?php

namespace Model;

class Ticket extends \Core\Model\Base {

	/**
	 * Construct
	 */
	public function __construct() {

		$this->schema(
			new \Column\Varchar('title', array('length' => 150, 'required' => 'Title field is required.')),
			new \Column\Text('description', array('required' => 'Description field is required.')),
			new \Column\Int('type', array('template' => 'select', 'choices' => array(

				1 => 'Bug',
				2 => 'Feature Request',
				3 => 'Optimization'

			)))
		);

		$this->admin('title');
		$this->admin('type');
		$this->admin('description', array('list' => false));

	}

}