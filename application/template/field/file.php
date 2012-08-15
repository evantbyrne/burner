<?php $this->error($field); ?>
<p><?php e($label); ?></p>

<?php if(!empty($value) and $model !== null): ?>

	<?php

	$column = $model->get_schema_column($field);
	$location = $column->get_option('dir') . "/{$model->id}.$value";

	?>

	<p><small>Choose new file to replace uploaded one: <a href="<?php echo url($location); ?>"><?php e($location); ?></a></small></p>

<?php endif; ?>

<p><input type="file" name="<?php echo $field; ?>" /></p>