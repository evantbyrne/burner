<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', "$model | Admin ") ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<h2><?php echo $model; ?></h2>

<?php $this->end_extend(); ?>