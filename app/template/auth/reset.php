<?php $this->base('admin/base'); ?>


<!-- Title -->
<?php $this->set('title', 'Password Reset'); ?>


<!-- Headline -->
<?php $this->extend('header'); ?>Password Reset<?php $this->end_extend(); ?>


<!-- Breadcrumbs -->
<?php $this->extend('breadcrumbs'); ?>

	<ul class="breadcrumb">
		<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
		<li><a href="<?php echo route_url('get', 'App.Controller.Auth', 'login'); ?>">Log In</a> <span class="divider">/</span></li>
		<li class="active">Password Reset</li>
	</ul>

<?php $this->end_extend(); ?>


<!-- Main Content -->
<?php $this->extend('content'); ?>

	<form method="post" class="form-horizontal">
	
		<?php if(isset($error)): ?>
		
			<p>Error: Password reset not found. Request a password reset <a href="<?php echo route_url('get', 'App.Controller.Auth', 'reset_request'); ?>">here</a>.</p>
		
		<?php endif; ?>
		
		<p>New Password: <input type="password" name="password" /></p>
		<p><input type="submit" value="Reset Password" class="btn btn-primary" /></p>
		
	</form>
	
<?php $this->end_extend(); ?>