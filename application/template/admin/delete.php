<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Delete ' . ucfirst($model) . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Delete ' . ucfirst($model)); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'model', array($model)); ?>"><?php echo ucfirst($model); ?></a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'edit', array($model, $id)); ?>">Edit</a> <span class="divider">/</span></li>
		<li class="active">Delete</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<p>Are you sure that you want to delete this database record?</p>

	<form method="post">

		<p><input type="submit" value="Delete" class="btn btn-danger" /></p>

	</form>

<?php $this->end_extend(); ?>