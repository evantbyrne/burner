<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Admin Index'); ?>


<!-- Header -->
<?php $this->set('header', 'Models'); ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<?php if(empty($models)): ?>
		
		<p>No models configured to be manageable from admin.</p>
		
	<?php else: ?>
	
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th width="80">Count</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach($models as $model_class => $model): ?>
			
					<tr>
						<td><a href="<?php echo route_url('get', 'admin', 'model', array($model_class)); ?>"><?php echo $model['name']; ?></a></td>
						<td><span class="badge"><?php echo $model['count']; ?></span></td>
					</tr>
				
				<?php endforeach; ?>

			</tbody>
		</table>
		
	<?php endif; ?>

<?php $this->end_extend(); ?>