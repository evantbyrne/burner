<?php $this->base('admin/base_no_side'); ?>


<!-- Title -->
<?php $this->set('title', 'Admin Index'); ?>


<!-- Header -->
<?php $this->set('header', 'Dashboard'); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<?php if(empty($models)): ?>
		
		<p>No models configured to be manageable from admin.</p>
		
	<?php else: ?>
	
		<?php foreach($models as $group_name => $group_models): ?>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?= e($group_name); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach($group_models as $model_class => $model): ?>
				
						<tr>
							<td><a href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'model', array($model_class)); ?>"><?= $model['name']; ?></a></td>
						</tr>
					
					<?php endforeach; ?>

				</tbody>
			</table>

		<?php endforeach; ?>
		
	<?php endif; ?>

<?php $this->end_extend(); ?>