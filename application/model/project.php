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

	/**
	 * Preview
	 * @option type = Image
	 * @option required = Image field is required.
	 */
	public $preview;

	/**
	 * Preview Path
	 * @return string
	 */
	public function preview_path() {

		return "static/project/{$this->id}";

	}

}