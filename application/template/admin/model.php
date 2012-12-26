<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li class="active"><?php echo $model_name; ?></li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			<li><a href="<?php echo route_url('get', 'admin', 'add', array($model)); ?>"><i class="icon-plus"></i> Add <?php echo $model_name; ?></a></li>
		</ul>
	</div>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>
	
	<?php if(empty($rows)): ?>
		
		<p>No rows found.</p>
		
	<?php else: ?>
	
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>&nbsp;</th>
					
					<?php foreach($columns as $column => $options): ?>
						
						<th><?php echo $column; ?></th>
						
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rows as $row): ?>
					<tr>
						<td style="width:45px;">
							<a class="btn" href="<?php echo route_url('get', 'admin', 'edit', array($model, $row->id)); ?>">Edit</a>
						</td>

						<?php foreach($columns as $column => $options): ?>
							<td>
								<?php if($this->exists("field/list/{$options['list_template']}")): ?>
									
									<?php $this->load("field/list/{$options['list_template']}", array(
										'field'   => $column,
										'options' => $options,
										'model'   => $row
									)); ?>
								
								<?php else: ?>
								
									<?php echo e($row->{$column}); ?>

								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
					
				<?php endforeach; ?>
			</tbody>
		</table>
		
	<?php endif; ?>

<?php $this->end_extend(); ?>