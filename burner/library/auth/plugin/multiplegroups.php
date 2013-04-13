<?php

namespace Library\Auth\Plugin;

/**
 * Auth Library Multiple Groups Plugin
 *
 * Authenticates exactly like the Standard plugin does, but
 * enforce() checks against Membership and Group models.
 */
class MultipleGroups extends Standard {

	/**
	 * @inheritdoc
	 */
	public static function enforce($group = false) {

		if(!self::logged_in()) {
			
			login_redirect(CURRENT_PAGE);
			
		}

		if($group !== false) {

			$res = self::current_user()
				->groups()
				->select()
				->and_where(\App\Model\Group::table() . '.name', '=', $group)
				->single();

			if($res === null) {

				\Core\Bootstrap::controller('App.Controller.Error', '_403');
				exit;

			}

		}

	}

}