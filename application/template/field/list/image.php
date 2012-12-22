<?php if(!empty($model->{$field})): ?>
	
	<?php $location = $model->{$field . '_path'}() . '.' . $model->{$field}; ?>
	<img style="max-width:50px;max-height:50px;" src="<?php e(url($location)); ?>" />

<?php endif; ?>