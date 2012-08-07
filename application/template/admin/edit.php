<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Edit ' . ucfirst($model) . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Edit ' . ucfirst($model)); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo url('admin'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo url("admin/$model"); ?>"><?php echo ucfirst($model); ?></a> <span class="divider">/</span></li>
		<li class="active">Edit</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			<li><a href="<?php echo url("admin/$model/delete/{$row->id}"); ?>"><i class="icon-minus"></i>Delete</a></li>
		</ul>
	</div>

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