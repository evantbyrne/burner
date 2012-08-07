<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Register'); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Register<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">Register</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<p>Your registration is almost complete. An email has been sent to you with
		a link. You must click that link to actiivate your account.</p>

<?php $this->end_extend(); ?>