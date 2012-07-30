<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', $title); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<p>This is the awesome template, which is being used instead of the default one.</p>
	
<?php $this->end_extend(); ?>