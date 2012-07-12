<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', $article->title); ?>


<!--Content -->
<?php $this->extend('content'); ?>

	<h2><?php echo $article->title; ?></h2>

	<p><?php echo $article->content; ?></p>
	
<?php $this->end_extend(); ?>