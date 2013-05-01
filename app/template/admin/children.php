<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?= url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'model', array($parent_model)); ?>"><?= $parent_name; ?></a> <span class="divider">/</span></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'edit', array($parent_model, $parent_id)); ?>">Edit</a> <span class="divider">/</span></li>
		<li class="active"><?= $model_name; ?></li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'add_child', array($parent_model, $parent_id, $child_model)); ?>"><i class="icon-plus"></i> Add <?= $model_name; ?></a></li>
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
						
						<th><?= str_replace('_', ' ', $column); ?></th>
						
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rows as $row): ?>
					<tr>
						<td style="width:45px;">
							<a class="btn" href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'edit_child', array($parent_model, $parent_id, $model, $row->id)); ?>">Edit</a>
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
								
									<?= e($row->{$column}); ?>

								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
					
				<?php endforeach; ?>
			</tbody>
		</table>
		
	<?php endif; ?>

	<?php if($next or $prev): ?>
		<p>
			<?php if($prev): ?><a href="<?= $prev; ?>">Previous</a><?php endif; ?>&nbsp;
			<?php if($next): ?><a href="<?= $next; ?>">Next</a><?php endif; ?>
		</p>
	<?php endif; ?>

<?php $this->end_extend(); ?>