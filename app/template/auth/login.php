<?php $this->base('admin/base_no_side'); ?>


<!-- Title -->
<?php $this->extend('title'); ?>Log In<?php $this->end_extend(); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Log In<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?= url(); ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">Log In</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Content -->
<?php $this->extend('content'); ?>
	
	<form method="post" class="form-horizontal">

		<?php if($invalid): ?><p>Invalid login credentials.</p><?php endif; ?>

		<?php foreach($user->get_schema() as $column => $options): ?>

			<?php $this->label($column); ?>
			<?php $this->field($column, $user); ?>

		<?php endforeach; ?>
		
		<p><input type="submit" value="Login" class="btn btn-primary" /></p>

	</form>

<?php $this->end_extend(); ?>