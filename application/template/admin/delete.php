<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', 'Delete ' . ucfirst($model) . ' | Admin ') ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<h2>Delete <?php echo ucfirst($model); ?></h2>

	<p>Are you sure that you want to delete this database record? <a href="<?php echo url("admin/$model/$id"); ?>">Cancel</a></p>

	<form method="post">

		<p><input type="submit" value="Delete" /></p>

	</form>

<?php $this->end_extend(); ?>