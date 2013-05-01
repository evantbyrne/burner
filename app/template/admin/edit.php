<?php $this->base('admin/base_no_side'); ?>


<!-- Title -->
<?php $this->set('title', 'Edit ' . $model_name . ' | Admin ') ?>


<!-- Header -->
<?php $this->set('header', 'Edit ' . $model_name); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?= url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'index'); ?>">Admin</a> <span class="divider">/</span></li>
		<li><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'model', array($model)); ?>"><?= $model_name; ?></a> <span class="divider">/</span></li>
		<li class="active">Edit</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
		<li class="active"><a href="#edit" data-toggle="tab">Edit</a></li>
		<?php if(!empty($inlines)): ?>

			<?php foreach($inlines as $name => $child): ?>

				<li><a href="#<?= e($name); ?>"><?= $child['verbose_plural']; ?></a></li>

			<?php endforeach; ?>

		<?php endif; ?>
	</ul>

	<div class="tab-content">

		<div class="tab-pane active" id="edit">

			<form method="post"<?php if($is_multipart): ?> enctype="multipart/form-data"<?php endif; ?>>

				<?php foreach($columns as $name => $c): ?>

					<?php $this->label($name); ?>
					<?php $this->field($name, $row, $c['options']); ?>

				<?php endforeach; ?>

				<div class="form-actions">
					<input type="submit" value="Save" class="btn btn-primary" />
					<a class="btn pull-right" href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'delete', array($model, $row->id)); ?>">Delete</a>
				</div>

			</form>

		</div>

		<?php if(!empty($inlines)): ?>

			<?php foreach($inlines as $name => $child): ?>

				<div class="tab-pane" id="<?= e($name); ?>">

					<p><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'add_child', array($model, $row->id, $name)); ?>"><i class="icon-plus"></i> Add <?= $child['verbose']; ?></a></p>

					<?php if(empty($child['rows'])): ?>

						<p>No rows found.</p>

					<?php else: ?>
			
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>&nbsp;</th>
									
									<?php foreach($child['columns'] as $column => $options): ?>
										
										<th><?= str_replace('_', ' ', $column); ?></th>
										
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach($child['rows'] as $child_row): ?>
									
									<tr data-model="<?= e($name); ?>" data-id="<?= e($child_row->id); ?>">
										
										<td style="width:45px;">
											<a class="btn" href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'edit_child', array($model, $row->id, $name, $child_row->id)); ?>">Edit</a>
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
												
													<?= e($child_row->{$column}); ?>

												<?php endif; ?>
											</td>
										<?php endforeach; ?>
									
									</tr>
									
								<?php endforeach; ?>
							</tbody>
						</table>

					<?php endif; ?>

				</div>

			<?php endforeach; ?>
			
		<?php endif; ?>

	</div>

<?php $this->end_extend(); ?>