<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Password Reset Request'); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<h2>Request Password Reset</h2>

	<form method="post">
	
		<?php if(isset($error)): ?>
		
			<p>Error: Invalid email. Are you sure you have an account?</p>
		
		<?php endif; ?>
		
		<p>Email: <input type="email" name="email" /></p>
		<p><input type="submit" value="Request Reset" /></p>
		
	</form>
	
<?php $this->end_extend(); ?>