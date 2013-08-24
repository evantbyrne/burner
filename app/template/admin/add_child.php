<?php $this->base('admin/base_no_side'); ?>


<!-- Title -->
<?php $this->set('title', 'Add ' . $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Add ' . $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?= url(); ?>">Home</a></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'index'); ?>">Admin</a></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'model', array($parent_model)); ?>"><?= $parent_name; ?></a></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'edit', array($parent_model, $parent_id)); ?>">Edit</a></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'children', array($parent_model, $parent_id, $model)); ?>"><?= $model_name; ?></a></li>
		<li class="active">Add</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post"<?php if($is_multipart): ?> enctype="multipart/form-data"<?php endif; ?>>

		<fieldset>

			<?php foreach($columns as $name => $c): ?>

				<?php if($name == $parent_model): ?>
				
					<input type="hidden" name="<?= e($parent_model); ?>" value="<?= e($parent_id); ?>" /> 
				
				<?php else: ?>

					<div class="form-group">
					
						<?php $this->error($name, 'admin/error'); ?>
						<?php $this->admin_label($name); ?>
						<?php $this->admin_field($name, $row, $c['options']); ?>
						
					<div>

				<?php endif; ?>

			<?php endforeach; ?>

			<input type="submit" value="Save" class="btn btn-primary" />

		</fieldset>

	</form>

<?php $this->end_extend(); ?>