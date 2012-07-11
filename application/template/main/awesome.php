<?php $this->base('base'); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<p>This is the awesome template, which is being used instead of the default one.</p>
	
<?php $this->end_extend(); ?>


<!-- Title -->
<?php

$this->extend('title');
$this->show('title');
$this->end_extend();

?>