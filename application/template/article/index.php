<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Articles'); ?>


<!--Content -->
<?php $this->extend('content'); ?>

	<h2>Articles</h2>

	<?php if(!empty($articles)): ?>

		<ul>

			<?php foreach($articles as $article): ?>

				<li><a href="<?php echo url("article/{$article->id}"); ?>"><?php e($article->title); ?></a></li>

			<?php endforeach; ?>

		</ul>

	<?php else: ?>

		<p>No articles to display!</p>

	<?php endif; ?>
	
<?php $this->end_extend(); ?>