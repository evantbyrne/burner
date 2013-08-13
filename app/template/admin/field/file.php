<?php if(!empty($value) and $model !== null and empty($errors[$field]) and isset($model->id)): ?>

	<?php $location = $model->{$field . '_url'}(); ?>
	<p><small>Choose new file to replace uploaded one: <a href="<?= e($location); ?>"><?= e($location); ?></a></small></p>

<?php endif; ?>

<p><input type="file" name="<?= $field; ?>" /></p>