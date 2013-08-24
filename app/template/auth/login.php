<?php $this->base('admin/base_no_side'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Log In<?php $this->end_extend(); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Log In<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?= url(); ?>">Home</a></li>
		<li class="active">Log In</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>
	
	<form method="post">

		<fieldset>

			<?php if($invalid): ?>
				<div class="alert alert-danger">Invalid login credentials.</div>
			<?php endif; ?>

			<?php foreach($user->get_schema() as $column => $options): ?>

				<div class="form-group">

					<?php $this->error($column, 'admin/error'); ?>
					<?php $this->admin_label($column); ?>
					<?php $this->admin_field($column, $user); ?>

				</div>

			<?php endforeach; ?>
			
			<input type="submit" value="Login" class="btn btn-primary" />

		</fieldset>

	</form>

<?php $this->end_extend(); ?>