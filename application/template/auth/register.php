<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Register<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<h2>Register</h2>
	
	<form method="post">

		<?php $this->field('Email:', 'email', 'email'); ?>

		<?php $this->field('Password:', 'password', 'password'); ?>

		<?php $this->field('Confirm Password:', 'password_confirm', 'password'); ?>

		<p><input type="submit" value="Register" /></p>

	</form>

<?php $this->end_extend(); ?>