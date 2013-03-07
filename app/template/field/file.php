<?php if(!empty($value) and $model !== null and empty($errors[$field]) and isset($model->id)): ?>

	<?php $location = $model->{$field . '_path'}() . '.' . $model->{$field}; ?>

	<p><small>Choose new file to replace uploaded one: <a href="<?php e(url($location)); ?>"><?php e($location); ?></a></small></p>

<?php endif; ?>

<p><input type="file" name="<?php echo $field; ?>" /></p>