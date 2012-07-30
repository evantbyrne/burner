<?php $this->error($field); ?>
<p><?php $this->show('label'); ?></p>
<p><select name="<?php echo $field; ?>">

	<?php foreach($options as $key => $name): ?>

		<option value="<?php echo $key ?>"<?php if($value == $key) { echo ' SELECTED'; } ?>><?php echo $name; ?></option>

	<?php endforeach; ?>

</select></p>