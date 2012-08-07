<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Register<?php $this->end_extend(); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Register<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">Register</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			<li><a href="<?php echo url("auth/login"); ?>"><i class="icon-lock"></i>Log In</a></li>
		</ul>
	</div>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>
	
	<form method="post" class="form-horizontal">

		<?php $this->field('Email:', 'email', 'email'); ?>

		<?php $this->field('Password:', 'password', 'password'); ?>

		<?php $this->field('Confirm Password:', 'password_confirm', 'password'); ?>

		<p><input type="submit" value="Register" class="btn btn-primary" /></p>

	</form>

<?php $this->end_extend(); ?>