<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', "$model | Admin ") ?>


<!-- Header -->
<?php $this->set('header', ucfirst($model)); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo url('admin'); ?>">Admin</a> <span class="divider">/</span></li>
		<li class="active"><?php echo ucfirst($model); ?></li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Sidebar -->
<?php $this->extend('sidebar'); ?>

	<div class="well">
		<ul class="nav nav-list">
			<li><a href="<?php echo url("admin/$model/add"); ?>"><i class="icon-plus"></i>Add <?php echo ucfirst($model); ?></a></li>
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
					<?php foreach($columns as $column => $options): ?>
						
						<th><?php echo $column; ?></th>
						
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($rows as $row): ?>
					
					<tr>
						<?php foreach($columns as $column => $options): ?>

							<?php if($this->first()): ?>
								
								<td><a href="<?php echo url("admin/$model/{$row->id}"); ?>"><?php echo $row->{$column}; ?></a></td>
							
							<?php else: ?>
								
								<td><?php echo $row->{$column}; ?></td>
							
							<?php endif; ?>
						
						<?php endforeach; ?>
						<?php $this->reset_first(); ?>
					</tr>
					
				<?php endforeach; ?>
			</tbody>
		</table>
		
	<?php endif; ?>

<?php $this->end_extend(); ?>