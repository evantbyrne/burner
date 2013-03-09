<?php $this->base('admin/base_modal'); ?>


<!-- Title -->
<?php $this->set('title', 'Add ' . $model_name) ?>


<!-- Content -->
<?php $this->extend('content') ?>

	<form method="post"<?php if($is_multipart): ?> enctype="multipart/form-data"<?php endif; ?> class="ajax-add-modal-form">

		<?php foreach($columns as $name => $c): ?>

			<?php $this->label($name); ?>
			<?php $this->field($name, $row, $c['options']); ?>

		<?php endforeach; ?>

	</form>

<?php $this->end_extend(); ?>


<!-- Controls -->
<?php $this->append('controls'); ?>

	<button class="btn btn-primary ajax-add-modal-save" data-model="<?php echo $model; ?>" data-url="<?php echo route_url('get', 'App.Vendor.Admin.Controller.Admin', 'ajax_add_modal', array($model)); ?>">Save</button>

<?php $this->end_append(); ?>