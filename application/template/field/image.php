<?php $this->error($field); ?>
<p><?php e($label); ?></p>

<?php if(!empty($value) and $model !== null and empty($errors[$field])): ?>

	<?php $location = $model->{$field . '_path'}() . '.' . $model->{$field}; ?>

	<p><small>Choose new file to replace uploaded one:</small></p>
	<ul class="thumbnails">
		<li style="margin:0">
			<a href="<?php e(url($location)); ?>" class="thumbnail">
				<img style="max-width:300px" src="<?php e(url($location)); ?>" />
			</a>
		</li>
	</ul>

<?php endif; ?>

<p><input type="file" name="<?php echo $field; ?>" /></p>