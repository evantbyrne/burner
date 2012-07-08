<?php $this->base('base'); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<p>Hello, World!</p>
	
<?php $this->end_extend(); ?>


<!-- Optional -->
<?php $this->extend('optional'); ?>

	<p>WOOOoooOOOooOooo</p>

<?php $this->end_extend(); ?>