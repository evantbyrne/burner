<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Login<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<h2>Log In</h2>
	
	<form method="post">

		<?php $this->field('Email:', 'email', 'email'); ?>

		<?php $this->field('Password:', 'password', 'password'); ?>

		<p><input type="submit" value="Login" /></p>

	</form>

<?php $this->end_extend(); ?>