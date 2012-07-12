<?php $this->base('base'); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<p>Hello, World!</p>
	
<?php $this->end_extend(); ?>


<!-- Title -->
<?php $this->set('title', $title); ?>