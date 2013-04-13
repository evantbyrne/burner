<?php

namespace Library\Auth\Model;

/**
 * Multiple Groups: Membership
 * @author Evan Byrne
 */
class MultipleGroups_Membership extends \Core\Model\Base {

	/**
	 * User
	 * @option type = BelongsTo
	 */
	public $user;

	/**
	 * Group
	 * @option type = BelongsTo
	 */
	public $group;

	/**
	 * To String
	 * @return string User and group
	 */
	public function __toString() {

		return "{$this->user}: {$this->group}";

	}

}