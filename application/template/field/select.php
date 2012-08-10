<?php $this->error($field); ?>
<p><?php e($label); ?></p>
<p><select name="<?php echo $field; ?>">

	<?php foreach($options as $key => $name): ?>

		<option value="<?php echo $key ?>"<?php if($value == $key) { echo ' SELECTED'; } ?>><?php e($name); ?></option>

	<?php endforeach; ?>

</select></p>