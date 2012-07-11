<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->extend('title') ?>Admin Index<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<h2>Models</h2>
	
	<?php if(empty($models)): ?>
		
		<p>No models configured to be manageable from admin.</p>
		
	<?php else: ?>
	
		<ul>
		
			<?php foreach($models as $model): ?>
		
				<li><a href="<?php echo url("admin/$model"); ?>"><?php echo ucfirst($model); ?></a></li>
			
			<?php endforeach; ?>
		
		</ul>
		
	<?php endif; ?>

<?php $this->end_extend(); ?>