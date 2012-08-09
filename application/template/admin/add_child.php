<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Add ' . ucfirst($model) . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Add ' . ucfirst($model)); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'model', array($parent_model)); ?>"><?php echo ucfirst($parent_model); ?></a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'edit', array($parent_model, $parent_id)); ?>">Edit</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'children', array($parent_model, $parent_id, $model)); ?>"><?php echo ucfirst($model); ?></a> <span class="divider">/</span></li>
		<li class="active">Add</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post" class="form-horizontal">

		<?php foreach($columns as $name => $c): ?>

			<?php if($name == $parent_model): ?>
			
				<input type="hidden" name="<?php e($parent_model); ?>" value="<?php e($parent_id); ?>" /> 
			
			<?php else: ?>
				
				<?php $this->field(ucfirst($name), $name, $c['options']['template'], $c['value'], $c['options']['choices']); ?>
				
			<?php endif; ?>

		<?php endforeach; ?>

		<p><input type="submit" value="Save" class="btn btn-primary" /></p>

	</form>

<?php $this->end_extend(); ?>