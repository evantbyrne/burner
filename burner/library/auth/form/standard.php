<?php

namespace Library\Auth\Form;

/**
 * Standard User Form
 * @author Evan Byrne
 */
class Standard extends \Core\Form\Base {

	/**
	 * Email
	 * @option type = Email
	 * @option length = 100
	 * @option required = Email field is required.
	 */
	public $email;

	/**
	 * Password
	 * @option type = Password
	 * @option required = Password field is required.
	 */
	public $password;

}