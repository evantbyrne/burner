<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Page Not Found'); ?>


<!-- Content -->
<?php $this->extend('content'); ?>
	
	<h2>Page not found</h2>
	
	<p>Sorry, the requested page could not be found.</p>

<?php $this->end_extend(); ?>