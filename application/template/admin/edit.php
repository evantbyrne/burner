<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Edit ' . ucfirst($model) . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Edit ' . ucfirst($model)); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'model', array($model)); ?>"><?php echo ucfirst($model); ?></a> <span class="divider">/</span></li>
		<li class="active">Edit</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			
			<li><a href="<?php echo route_url('get', 'admin', 'delete', array($model, $row->id)); ?>"><i class="icon-minus"></i>Delete</a></li>
		
			<?php if(!empty($children)): ?>
				
					<li class="divider"></li>
				
				<?php foreach($children as $name => $child_model): ?>
					
					<li><a href="<?php echo route_url('get', 'admin', 'children', array($model, $row->id, $child_model)); ?>"><i class="icon-pencil"></i><?php echo ucfirst($name); ?></a></li>
					
				<?php endforeach; ?>
			
			<?php endif; ?>
		
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