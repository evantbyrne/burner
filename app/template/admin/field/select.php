<p><select name="<?= $field; ?>">

	<?php foreach($options['choices'] as $key => $name): ?>

		<option value="<?= $key ?>"<?php if($value == $key) { echo ' SELECTED'; } ?>><?= e($name); ?></option>

	<?php endforeach; ?>

</select></p>