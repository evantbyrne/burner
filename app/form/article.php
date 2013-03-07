<?php

namespace Form;

/**
 * Example Article Form
 */
class Article extends \Core\Form\Base {
	
	/**
	 * Title
	 * @option type = Varchar
	 * @option length = 125
	 * @option required = Title field is required.
	 */
	public $title;

	/**
	 * Content
	 * @option type = Text
	 * @option required = Content field is required.
	 */
	public $content;

	/**
	 * Title Validator
	 * @param mixed Value
	 * @return mixed True when valid, string when invalid
	 */
	public function title_validator($value) {

		if(strlen($value) < 3) {

			return 'Title must be at least 3 characters long.';

		}

		return true;

	}

}