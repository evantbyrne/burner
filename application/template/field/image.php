<?php $this->error($field); ?>
<p><?php e($label); ?></p>

<?php if(!empty($value) and $model !== null and empty($errors[$field])): ?>

	<?php $location = $model->{$field . '_path'}(); ?>

	<p><small>Choose new file to replace uploaded one:</small></p>
	<p><a href="<?php e(url($location)); ?>"><img style="max-width:300px" src="<?php e(url($location)); ?>" /></a></p>

<?php endif; ?>

<p><input type="file" name="<?php echo $field; ?>" /></p>