<?php

namespace App\Vendor\Auth\Controller;

/**
 * Auth Controller
 * @author Evan Byrne
 */
class Auth extends \Core\Controller\Base {
	
	/**
	 * Login
	 */
	public function login($redirect = false) {
		
		$form_class = to_php_namespace('Library.Auth.Form.' . \Core\Config::get('auth_plugin'));
		$this->data('invalid', false);
		$this->data('user', new $form_class());

		if(is_post()) {
			
			$user = $form_class::from_post();
			$this->data('user', $user);
			
			$errors = $user->valid();
			if(!is_array($errors)) {

				$auth = new \Library\Auth($user->to_array());
				if($auth->valid()) {

					$auth->login();
					if($redirect) {
				
						redirect(base64_decode($redirect));
					
					}
					
					redirect();

				} else {

					$this->data('invalid', true);

				}

			} else {

				$this->data('errors', $errors);

			}
		
		}
		
	}

	public function logout() {

		\Library\Auth::logout();
		redirect();

	}

}