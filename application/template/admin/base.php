<!DOCTYPE html>
<html>
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title><?php $this->section('title'); ?>Admin<?php $this->end_section(); ?></title>
		
		<?php $this->section('styles'); ?>
			<link rel="stylesheet" href="<?php echo url('static/admin/css/bootstrap.css'); ?>" />
			<link rel="stylesheet" href="<?php echo url('static/admin/css/bootstrap-responsive.css'); ?>" />
			<link rel="stylesheet" href="<?php echo url('static/admin/css/rewrite.css'); ?>" />
		<?php $this->end_section(); ?>

	</head>
	<body>

		<!-- Navigation -->
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand"><?php $this->section('brand'); ?>Burner<?php $this->end_section(); ?></a>
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="nav-collapse">
						<ul class="nav pull-right">
							
							<?php if(\Controller\Auth::logged_in()): ?>
								
								<li class="active"><a href="javascript:;"><?php echo 'Welcome, ' . \Controller\Auth::user()->email; ?></a></li>
								<li><a href="<?php echo route_url('get', 'auth', 'logout'); ?>">Log Out</a></li>
							
							<?php endif; ?>

						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Container -->
		<div class="container-fluid">
			
			<?php $this->section('breadcrumbs'); ?>
			
				<ul class="breadcrumb">
					<li><a href="<?php echo url(); ?>">Home</a> <span class="divider">/</span></li>
					<li class="active">Admin</li>
				</ul>
			
			<?php $this->end_section(); ?>
			
			<div class="page-header">
				<h3><?php $this->section('header'); ?>Admin<?php $this->end_section(); ?></h3>
			</div>

			<div class="row-fluid show-grid">
				<div class="span8">
					
					<?php $this->section('content'); ?>

						<!-- Defualt Content -->

					<?php $this->end_section(); ?>

				</div>
				<div class="span4">
					
					<?php $this->section('sidebar'); ?>

						<!-- Defualt Sidebar -->

					<?php $this->end_section(); ?>

				</div>
			</div>
			
			<?php $this->section('footer'); ?>

				<!-- Default Footer -->

			<?php $this->end_section(); ?>
		</div>

		<?php $this->section('scripts'); ?>
			<script src="<?php echo url('static/admin/js/jquery.min.js'); ?>"></script>
			<script src="<?php echo url('static/admin/js/bootstrap.min.js'); ?>"></script>
		<?php $this->end_section(); ?>

	</body>
</html>