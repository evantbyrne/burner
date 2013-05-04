<?php

namespace Library\Auth\Model;

/**
 * Multiple Groups
 * @author Evan Byrne
 */
class MultipleGroups extends \Core\Model\Base {

	/**
	 * Email
	 * @option type = Email
	 * @option length = 100
	 * @option required = Email field is required.
	 * @option unique = Email address already in use.
	 */
	public $email;

	/**
	 * Password
	 * @option type = Password
	 * @option required = Password field is required.
	 */
	public $password;

	/**
	 * Groups
	 * @option type = ManyToMany
	 * @option model = Group
	 * @option middleman = Membership
	 */
	public $groups;

	/**
	 * To String
	 * @return string Email
	 */
	public function __toString() {

		return $this->email;

	}

}