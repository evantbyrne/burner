<p>
	<span class="controls controls-row">
		<select name="<?php echo $field; ?>">

		<?php foreach($options['choices'] as $key => $name): ?>

			<option value="<?php echo $key ?>"<?php if($value == $key) { echo ' SELECTED'; } ?>><?php e($name); ?></option>

		<?php endforeach; ?>

		</select>
		<a href="javascript:;" class="btn btn-link ajax-add-modal" data-url="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'ajax_add_modal', array($field)); ?>" data-model="<?php echo $field; ?>"><i class="icon-plus"></i> New</a>
	</span>
</p>