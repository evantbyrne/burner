<?php

namespace App\Model;

class Ticket extends \Core\Model\Base {

	/**
	 * array Type choices
	 */
	protected static $type_choices = array(

		1 => 'Bug',
		2 => 'Feature Request',
		3 => 'Optimization'

	);

	/**
	 * Title
	 * @option type = Varchar
	 * @option length = 150
	 * @option required = Title field is required.
	 */
	public $title;

	/**
	 * Description
	 * @option type = Text
	 * @option required = Description field is required.
	 */
	public $description;

	/**
	 * Type
	 * @option type = Int
	 * @option choices = true
	 * @option template = select
	 */
	public $type;

}