<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Password Reset'); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Password Reset<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo url('auth/login'); ?>">Log In</a> <span class="divider">/</span></li>
		<li class="active">Password Reset</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<p>You have been sent an email that contains a link to reset your password.</p>
	
<?php $this->end_extend(); ?>