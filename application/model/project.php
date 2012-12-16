<?php

namespace Model;

class Project extends \Core\Model\Base {
	
	/**
	 * Title
	 * @option type = Varchar
	 * @option length = 100
	 * @option required = Title field is required.
	 */
	public $title;

	/**
	 * Description
	 * @option type = Text
	 */
	public $description;

}