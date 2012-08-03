<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Edit ' . ucfirst($model) . ' | Admin ') ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<h2>Edit <?php echo ucfirst($model); ?></h2>

	<p><a href="<?php echo url("admin/$model/delete/{$row->id}"); ?>">Delete</a></p>

	<form method="post">

		<?php foreach($columns as $name => $c): ?>

			<?php $this->field(ucfirst($name), $name, $c['options']['template'], $c['value'], $c['options']['choices']); ?>

		<?php endforeach; ?>

		<p><input type="submit" value="Save" /></p>

	</form>

<?php $this->end_extend(); ?>