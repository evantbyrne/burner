<?php $this->base('base'); ?>


<!-- Title -->
<?php $this->set('title', "$model | Admin ") ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<h2><?php echo ucfirst($model); ?></h2>
	
	<p><a href="<?php echo url("admin/$model/add"); ?>">Add</a></p>
	
	<?php if(empty($rows)): ?>
		
		<p>No rows found.</p>
		
	<?php else: ?>
	
		<table>
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