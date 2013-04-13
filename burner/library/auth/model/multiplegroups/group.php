<?php

namespace Library\Auth\Model;

/**
 * Multiple Groups: Group
 * @author Evan Byrne
 */
class MultipleGroups_Group extends \Core\Model\Base {

	/**
	 * Name
	 * @option type = Varchar
	 * @option length = 100
	 * @option required = Name field is required.
	 */
	public $name;

	/**
	 * Users
	 * @option type = ManyToMany
	 * @option model = User
	 * @option middleman = Membership
	 */
	public $users;

	/**
	 * To String
	 * @return string Name
	 */
	public function __toString() {

		return $this->name;

	}

}