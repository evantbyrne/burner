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
			<link rel="stylesheet" href="<?php echo url('static/admin/css/datepicker.css'); ?>" />
			<link rel="stylesheet" href="<?php echo url('static/admin/css/font-awesome.css'); ?>">
			<!--[if IE 7]>
				<link rel="stylesheet" href="<?php echo url('static/admin/css/font-awesome-ie7.css'); ?>">
			<![endif]-->
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
							
							<?php if(\Library\Auth::logged_in()): ?>
								
								<li class="active"><a href="javascript:;"><?php echo 'Welcome, ' . \Library\Auth::current_user()->email; ?></a></li>
								<li><a href="<?php echo route_url('get', 'App.Vendor.Auth.Controller.Auth', 'logout'); ?>">Log Out</a></li>
							
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

				<?php if(\Core\Config::get('debug')): ?>
					
					<p><small>Executed queries: <?php echo count(\Core\DB::connection()->queries()); ?></small></p>
				
				<?php endif; ?>

			<?php $this->end_section(); ?>
		</div>

		<?php $this->section('scripts'); ?>
			<script src="<?php echo url('static/admin/js/jquery.min.js'); ?>"></script>
			<script src="<?php echo url('static/admin/js/jquery-ui.min.js'); ?>"></script>
			<script src="<?php echo url('static/admin/js/bootstrap.min.js'); ?>"></script>
			<script src="<?php echo url('static/admin/js/bootstrap-datepicker.js'); ?>"></script>
			<script>
				$(document).ready(function() {

					// Date column
					$('.datepicker').datepicker({ format:'yyyy-mm-dd' });

					// Order column
					$('tbody:has(.order-column)').sortable({ update:function() {

						var data = {
							model: null,
							column: $(this).find('.order-column').attr('data-column'),
							order: []
						};

						$(this).find('tr').each(function() {

							if(data.model === null) {

								data.model = $(this).attr('data-model');

							}

							data.order[data.order.length] = $(this).attr('data-id');

						});

						data.order = JSON.stringify(data.order);
						$.post("<?php echo route_url('post', 'App.Vendor.Admin.Controller.Admin', 'ajax_order'); ?>", data);

					}});

				});
			</script>
		<?php $this->end_section(); ?>

	</body>
</html>