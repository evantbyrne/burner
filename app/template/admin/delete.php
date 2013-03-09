<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Delete ' . $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Delete ' . $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'model', array($model)); ?>"><?php echo $model_name; ?></a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'edit', array($model, $id)); ?>">Edit</a> <span class="divider">/</span></li>
		<li class="active">Delete</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<p>Are you sure that you want to delete this <?php echo strtolower($model_name); ?>?</p>

	<form method="post">

		<p><input type="submit" value="Delete" class="btn btn-danger" /></p>

	</form>

<?php $this->end_extend(); ?>