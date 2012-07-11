<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Register<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<h2>Register</h2>
	
	<form method="post">

		<?php $this->error('email'); ?>
		<p>
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" value="<?php $this->show('email'); ?>" />
		</p>

		<?php $this->error('password'); ?>
		<p>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" />
		</p>

		<?php $this->error('password_confirm'); ?>
		<p>
			<label for="password_confirm">Confirm Password:</label>
			<input type="password" name="password_confirm" id="password_confirm" />
		</p>

		<p><input type="submit" value="Register" /></p>

	</form>

<?php $this->end_extend(); ?>