<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Edit Article'); ?>


<!--Content -->
<?php $this->extend('content'); ?>

	<h2>Edit Article</h2>

	<form method="post">

		<?php $this->field('Title:', 'title', 'text'); ?>

		<?php $this->field('Content:', 'content', 'textarea'); ?>

		<p><input type="submit" value="Save" /></p>

	</form>
	
<?php $this->end_extend(); ?>