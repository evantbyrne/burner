<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Password Reset'); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Password Reset<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Controller.Auth', 'login'); ?>">Log In</a> <span class="divider">/</span></li>
		<li class="active">Password Reset</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<p>Your password has been reset.</p>
	
<?php $this->end_extend(); ?>