<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', $title); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<p>Hello, World!</p>
	
<?php $this->end_extend(); ?>