<p>
	<span class="controls controls-row">
		<select name="<?= $field; ?>">

		<?php foreach($options['choices'] as $key => $name): ?>

			<option value="<?= $key ?>"<?php if($value == $key) { echo ' SELECTED'; } ?>><?= e($name); ?></option>

		<?php endforeach; ?>

		</select>
		<a href="javascript:;" class="btn btn-link ajax-add-modal" data-url="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'ajax_add_modal', array($field)); ?>" data-model="<?= $field; ?>"><i class="icon-plus"></i> New</a>
	</span>
</p>