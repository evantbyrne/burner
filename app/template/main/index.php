<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', $title); ?>


<!-- Main Content -->
<?php $this->append('content'); ?>

	<p>In addition to default content!</p>
	
<?php $this->end_append(); ?>


<?php $this->append('content'); ?>

	<p>Third!</p>
	
<?php $this->end_append(); ?>