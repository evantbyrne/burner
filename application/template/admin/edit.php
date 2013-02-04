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
		<li><a href="<?php echo route_url('get', 'admin', 'model', array($model)); ?>"><?php echo $model_name; ?></a> <span class="divider">/</span></li>
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

			<?php $this->label($name); ?>
			<?php $this->field($name, $row, $c['options']); ?>

		<?php endforeach; ?>

		<p><input type="submit" value="Save" class="btn btn-primary" /></p>

	</form>

	<?php if(!empty($inlines)): ?>

		<?php foreach($inlines as $name => $child): ?>

			<div class="page-header">
				<h3><?php echo $child['verbose_plural']; ?></h3>
			</div>

			<p><a href="<?php echo route_url('get', 'admin', 'add_child', array($model, $row->id, $name)); ?>"><i class="icon-plus"></i> Add <?php echo $child['verbose']; ?></a></p>

			<?php if(empty($child['rows'])): ?>

				<p>No rows found.</p>

			<?php else: ?>
	
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>&nbsp;</th>
							
							<?php foreach($child['columns'] as $column => $options): ?>
								
								<th><?php echo str_replace('_', ' ', $column); ?></th>
								
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach($child['rows'] as $child_row): ?>
							<tr>
								<td style="width:45px;">
									<a class="btn" href="<?php echo route_url('get', 'admin', 'edit_child', array($model, $row->id, $name, $child_row->id)); ?>">Edit</a>
								</td>

								<?php foreach($child['columns'] as $column => $options): ?>
									<td>
										<?php if($this->exists("field/list/{$options['list_template']}")): ?>
											
											<?php $this->load("field/list/{$options['list_template']}", array(
												'field'   => $column,
												'options' => $options,
												'model'   => $child_row
											)); ?>
										
										<?php else: ?>
										
											<?php echo e($child_row->{$column}); ?>

										<?php endif; ?>
									</td>
								<?php endforeach; ?>
							</tr>
							
						<?php endforeach; ?>
					</tbody>
				</table>

				<p><a href="<?php echo route_url('get', 'admin', 'add_child', array($model, $row->id, $name)); ?>"><i class="icon-plus"></i> Add <?php echo $child['verbose']; ?></a></p>

			<?php endif; ?>

		<?php endforeach; ?>
		
	<?php endif; ?>

<?php $this->end_extend(); ?>