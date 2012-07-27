<?php

namespace Core\Model;

/**
 * Base ACL Model
 * @author Evan Byrne
 */
abstract class ACL extends Base {
	
	/**
	 * @inheritdoc
	 */
	public static function columns() {
	
		return array(
		
			// Owner ID
			new \Column\Int('owner_id')
		
		);
		
	}
	
	/**
	 * Restrictions on model
	 */
	private $restrictions;
	
	/**
	 * Special owner permissions
	 */
	private $owner_permissions;
	
	/**
	 * Instance of \Model\Base\User who 'owns' this
	 */
	private $owner;
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		$this->restrictions = array();
		$this->owner_permissions = array();
		$this->owner = null;
		$this->owner_id = null;
	
	}
	
	/**
	 * Restrict
	 * @param Name of action to restrict
	 * @param User level to restrict to
	 */
	public function restrict($action, $level) {
	
		$this->restrictions[$action] = $level;
	
	}
	
	/**
	 * Allow Owner
	 * @param Name of action to allow owner to perform
	 */
	public function allow_owner($action) {
	
		$this->owner_permissions[] = $action;
	
	}
	
	/**
	 * Can
	 * @param \Model\Base\User object
	 * @param Name of action
	 */
	public function can($user, $action) {
	
		if(!is_a($user, '\\Model\\Base\\User')) {
		
			throw new \Exception('User object must inherit \\Model\\Base\\User.');
		
		}
		
		if($user->id == $this->owner_id and in_array($action, $this->owner_permissions)) {
			
			return true;
			
		}
		
		return ($user->type >= $this->restrictions[$action]);
	
	}
	
	/**
	 * Set Owner ID
	 * @param Integer value of ID column from a \\Model\\Base\\User object
	 */
	public function set_owner_id($id) {
	
		$this->owner_id = $id;
	
	}
	
	/**
	 * Get Owner ID
	 * @return Integer value of ID column from a \\Model\\Base\\User object
	 */
	public function get_owner_id() {
	
		return $this->owner_id;
	
	}
	
	/**
	 * Set Owner
	 * @param \Model\Base\User object
	 */
	public function set_owner($user) {
	
		if(!is_a($user, '\\Model\\Base\\User')) {
		
			throw new \Exception('User object must inherit \\Model\\Base\\User.');
		
		}
		
		$this->owner_id = $user->id;
		$this->owner = $user;
	
	}
	
	/**
	 * Get Owner
	 * @param Full name of model class to query from. Class must inherit from \Model\Base\User
	 * @return \Model\Base\User object
	 */
	public function get_owner($class) {
	
		if($this->owner === null) {
		
			$res = $class::select()->where('id', '=', $this->owner_id)->limit(1)->execute();
			if(empty($res)) {
			
				return false;
			
			} else {
			
				$this->owner = $res[0];
			
			}
		
		}
		
		return $this->owner;
	
	}

}