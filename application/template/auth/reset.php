<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Password Reset'); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<h2>Request Password</h2>

	<form method="post">
	
		<?php if(isset($error)): ?>
		
			<p>Error: Password reset not found. Request a password reset <a href="<?php echo url('auth/reset_request'); ?>">here</a>.</p>
		
		<?php endif; ?>
		
		<p>New Password: <input type="password" name="password" /></p>
		<p><input type="submit" value="Reset Password" /></p>
		
	</form>
	
<?php $this->end_extend(); ?>