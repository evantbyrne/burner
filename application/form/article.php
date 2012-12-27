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

}