<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Edit ' . $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Edit ' . $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'model', array($parent_model)); ?>"><?php echo $parent_name; ?></a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'edit', array($parent_model, $parent_id)); ?>">Edit</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'children', array($parent_model, $parent_id, $model)); ?>"><?php echo $model_name; ?></a> <span class="divider">/</span></li>
		<li class="active">Edit</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			
			<li><a href="<?php echo route_url('get', 'admin', 'delete', array($model, $row->id)); ?>"><i class="icon-minus"></i> Delete</a></li>
		
			<?php if(!empty($children)): ?>
				
					<li class="divider"></li>
				
				<?php foreach($children as $name => $child_model): ?>
					
					<li><a href="<?php echo route_url('get', 'admin', 'children', array($model, $row->id, $child_model)); ?>"><i class="icon-pencil"></i> <?php echo $name; ?></a></li>
					
				<?php endforeach; ?>
			
			<?php endif; ?>
		
		</ul>
	</div>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post"<?php if($is_multipart): ?> enctype="multipart/form-data"<?php endif; ?> class="form-horizontal">

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