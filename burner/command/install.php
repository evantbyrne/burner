<?php

namespace Core\Command;

/**
 * Install Command
 * @author Evan Byrne
 */
class Install {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ninstall\n\n";
		echo "Description:\n";
		echo "\tCreates MySQL tables for the User, Group, and Membership\n";
		echo "\tmodels if they don't already exist; creates 'admin'\n";
		echo "\tgroup if it doesn't exist; and prompts you to create an\n";
		echo "\tadmin user.\n\n";
		echo "\tOnly works with MultipleGroups auth plugin (which\n";
		echo "\tis the default). Running after insert error shouldn't\n";
		echo "\tmess up existing data.\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		// Create tables
		$c = new Create();
		$c->run('user', 'group', 'membership');

		// Create admin group
		$group = new \App\Model\Group();
		$group->name = 'admin';
		if(!$group->get()) {

			$group->save();
			echo "Group 'admin' created.\n\n";

		} else {

			echo "Group 'admin' already exists.\n\n";

		}

		// Prompt to create user
		echo "Create admin user.\n";
		$ins = new Insert();
		$user_id = $ins->run('App.Model.User');

		if($user_id !== null) {

			// Add user to admin group
			echo "Adding user to 'admin' group.\n\n";
			$m = new \App\Model\Membership();
			$m->group = $group->id;
			$m->user = $user_id;
			$m->save();

		}
		
	}
	
}