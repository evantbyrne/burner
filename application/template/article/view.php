<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', $article->title); ?>


<!--Content -->
<?php $this->extend('content'); ?>

	<h2><?php e($article->title); ?></h2>

	<p><?php e($article->content); ?></p>
	
	<p>Comments: <?php echo count($comments); ?></p>
	
<?php $this->end_extend(); ?>