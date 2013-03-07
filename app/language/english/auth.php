<?php

namespace App\Language;

class Auth {

	// Errors
	public static $error_confirmation_password = 'Confirmation password did not match.';
	public static $error_taken_email = 'Given email already belongs to registered user. Are you sure that you don\'t already have an account?';
	public static $error_invalid_login = 'Invalid email or password.';

	// Registration success
	public static $email_success_from = 'noreply@example.com';
	public static $email_success_title = 'Verify Your Registration';
	public static function email_success_message($verify_url) {
	
		return "We would like to welcome you to our site! However, before you can log in, you will " .
			"have to visit the following link to verify your email address is correct: $verify_url";
	
	}

	// Password reset
	public static $email_password_reset_from = 'noreply@example.com';
	public static $email_password_reset_title = 'Password Reset';
	public static function email_password_reset_message($reset_url) {
	
		return 'You have received this email because you requested a password reset. To reset your' .
			"password, visit the following link: $reset_url";
	
	}

}