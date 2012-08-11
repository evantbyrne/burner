<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Add ' . $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Add ' . $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'model', array($model)); ?>"><?php echo $model_name; ?></a> <span class="divider">/</span></li>
		<li class="active">Add</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post" class="form-horizontal">

		<?php foreach($columns as $name => $c): ?>

			<?php $this->field(ucfirst($name), $name, $c['options']['template'], $c['value'], $c['options']['choices']); ?>

		<?php endforeach; ?>

		<p><input type="submit" value="Save" class="btn btn-primary" /></p>

	</form>

<?php $this->end_extend(); ?>