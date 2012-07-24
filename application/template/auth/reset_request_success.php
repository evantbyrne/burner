<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Password Reset Request'); ?>


<!-- Content -->
<?php $this->extend('content'); ?>

	<p>You have been sent an email that contains a link to reset your password.</p>
	
<?php $this->end_extend(); ?>