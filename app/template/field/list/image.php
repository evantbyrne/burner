<?php if(!empty($model->{$field})): ?>
	
	<img style="max-width:50px;max-height:50px;" src="<?= e($model->{$field . '_url'}()); ?>" />

<?php endif; ?>