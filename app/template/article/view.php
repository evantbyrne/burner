<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', $article->title); ?>


<!--Content -->
<?php $this->extend('content'); ?>

	<h2><?= e($article->title); ?></h2>

	<p><?= e($article->content); ?></p>
	
	<p>Comments: <?= count($comments); ?></p>
	
<?php $this->end_extend(); ?>