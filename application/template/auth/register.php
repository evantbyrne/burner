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
			<li><a href="<?php echo route_url('get', 'auth', 'login'); ?>"><i class="icon-lock"></i> Log In</a></li>
		</ul>
	</div>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>
	
	<form method="post" class="form-horizontal">

		<?php $this->label('email'); ?>
		<?php $this->field('email', $user); ?>

		<?php $this->label('password'); ?>
		<?php $this->field('password', $user); ?>

		<?php $this->error('password_confirm'); ?>
		<p>Confirm Password</p>
		<p><input type="password" name="password_confirm" /></p>

		<p><input type="submit" value="Register" class="btn btn-primary" /></p>

	</form>

<?php $this->end_extend(); ?>