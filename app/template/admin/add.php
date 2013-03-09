<?php $this->base('admin/base_no_side'); ?>


<!-- Title -->
<?php $this->set('title', 'Add ' . $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Add ' . $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'model', array($model)); ?>"><?php echo $model_name; ?></a> <span class="divider">/</span></li>
		<li class="active">Add</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post"<?php if($is_multipart): ?> enctype="multipart/form-data"<?php endif; ?>>

		<div class="form-actions">
			<input type="submit" value="Save" class="btn btn-primary" />
		</div>

		<?php foreach($columns as $name => $c): ?>

			<?php $this->label($name); ?>
			<?php $this->field($name, $row, $c['options']); ?>

		<?php endforeach; ?>

	</form>

<?php $this->end_extend(); ?>