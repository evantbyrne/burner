<?php

namespace Controller;

/**
 * Example Admin Controller
 * @author Evan Byrne
 */
class Admin extends \Core\Controller\Admin {

	/**
	 * @inheritdoc
	 */
	public static $models = array('user', 'article', 'tag', 'articletag', 'comment', 'ticket', 'project');

}