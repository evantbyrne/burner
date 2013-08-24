<?php $this->base('admin/base_modal'); ?>


<!-- Title -->
<?php $this->set('title', 'Add ' . $model_name) ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post"<?php if($is_multipart): ?> enctype="multipart/form-data"<?php endif; ?> class="ajax-add-modal-form">

		<fieldset>

			<?php foreach($columns as $name => $c): ?>

				<div class="form-group">

					<?php $this->error($name, 'admin/error'); ?>
					<?php $this->admin_label($name); ?>
					<?php $this->admin_field($name, $row, $c['options']); ?>

				</div>

			<?php endforeach; ?>

		</fieldset>

	</form>

<?php $this->end_extend(); ?>


<!-- Controls -->
<?php $this->append('controls'); ?>

	<button class="btn btn-primary ajax-add-modal-save" data-model="<?= $model; ?>" data-url="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'ajax_add_modal', array($model)); ?>">Save</button>

<?php $this->end_append(); ?>