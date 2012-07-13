<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Login<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<h2>Log In</h2>
	
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

		<p><input type="submit" value="Login" /></p>

	</form>

<?php $this->end_extend(); ?>