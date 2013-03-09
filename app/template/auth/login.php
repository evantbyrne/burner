<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Log In<?php $this->end_extend(); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Log In<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">Log In</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			<li><a href="<?php echo route_url('get', 'App.Controller.Auth', 'register'); ?>"><i class="icon-plus"></i>Register</a></li>
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

		<p><a href="<?php echo route_url('get', 'App.Controller.Auth', 'reset_request'); ?>"><i class="icon-refresh"></i> Reset Password</a></p>
		
		<p><input type="submit" value="Login" class="btn btn-primary" /></p>

	</form>

<?php $this->end_extend(); ?>