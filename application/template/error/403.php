<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Access Denied'); ?>


<!-- Content -->
<?php $this->extend('content'); ?>
	
	<h2>Access denied</h2>
	
	<p>You do not have permission to access this resource.</p>

<?php $this->end_extend(); ?>