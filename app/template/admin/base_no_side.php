<!DOCTYPE html>
<html>
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title><?php $this->section('title'); ?>Admin<?php $this->end_section(); ?></title>
		
		<?php $this->section('styles'); ?>
			<link rel="stylesheet" href="<?= url('static/admin/css/bootstrap.min.css'); ?>" />
			<link rel="stylesheet" href="<?= url('static/admin/css/bootstrap-theme.min.css'); ?>" />
			<link rel="stylesheet" href="<?= url('static/admin/css/datepicker.css'); ?>" />
			<link rel="stylesheet" href="<?= url('static/admin/css/select2.css'); ?>" />
			<link rel="stylesheet" href="<?= url('static/admin/css/font-awesome.min.css'); ?>">
			<!--[if IE 7]>
				<link rel="stylesheet" href="<?= url('static/admin/css/font-awesome-ie7.min.css'); ?>">
			<![endif]-->
		<?php $this->end_section(); ?>

	</head>
	<body>

		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-top-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?= route_url('get', 'App.Vendor.Admin.Controller.Admin', 'index'); ?>"><?php $this->section('brand'); ?>Burner<?php $this->end_section(); ?></a>
				</div>
				<div class="collapse navbar-collapse navbar-top-collapse">
					<ul class="nav navbar-nav navbar-right">
						
						<?php if(\Library\Auth::logged_in()): ?>
							
							<li class="active"><a href="javascript:;">Welcome, <?= \Library\Auth::current_user()->email; ?></a></li>
							<li><a href="<?= route_url('get', 'App.Vendor.Auth.Controller.Auth', 'logout'); ?>">Log Out</a></li>
						
						<?php endif; ?>

					</ul>
				</div>
			</div>
		</nav>
		
		<!-- Container -->
		<div class="container">
			
			<?php $this->section('breadcrumbs'); ?>
			
				<ul class="breadcrumb">
					<li><a href="<?= url(); ?>">Home</a></li>
					<li class="active">Admin</li>
				</ul>
			
			<?php $this->end_section(); ?>
			
			<div class="page-header">
				<h3><?php $this->section('header'); ?>Admin<?php $this->end_section(); ?></h3>
			</div>

			<div class="row-fluid show-grid">
				<div class="span12">
					
					<?php $this->section('content'); ?>

						<!-- Defualt Content -->

					<?php $this->end_section(); ?>

				</div>
			</div>
			
			<?php $this->section('footer'); ?>

				<?php if(\Core\Config::get('debug')): ?>
					
					<p><small>Executed queries: <?= count(\Core\DB::connection()->queries()); ?></small></p>
				
				<?php endif; ?>

			<?php $this->end_section(); ?>
		</div>

		<!-- Modal -->
		<div id="modal"></div>

		<?php $this->section('scripts'); ?>
			<script src="<?= url('static/admin/js/jquery.min.js'); ?>"></script>
			<script src="<?= url('static/admin/js/jquery-ui.min.js'); ?>"></script>
			<script src="<?= url('static/admin/js/bootstrap.min.js'); ?>"></script>
			<script src="<?= url('static/admin/js/jquery.hotkeys.js'); ?>"></script>
			<script src="<?= url('static/admin/js/bootstrap-datepicker.js'); ?>"></script>
			<script src="<?= url('static/admin/js/bootstrap-wysiwyg.js'); ?>"></script>
			<script src="<?= url('static/admin/js/select2.min.js'); ?>"></script>
			<script>
				$(document).ready(function() {

					// Date picker
					$('.datepicker').datepicker({ format:'yyyy-mm-dd' });

					// WYSIWYG editor
					$('.wysiwyg').wysiwyg().on('input', function() {

						var field = $(this).attr('data-wysiwyg-field');
						$('input[name=' + field + ']').val($(this).html());

					});

					// Fancy select boxes
					// $('select').select2({width:'element'});

					// Tabs
					$('#tabs a').click(function() {

						$(this).tab('show');

					});

					// Modal
					$('.ajax-add-modal').click(function() {

						$.get($(this).attr('data-url'), function(data) {

							var modal = $('#modal');
							modal.html(data).find('> .modal').modal({ keyboard:true, backdrop:false, show:true });
							modal.find('.datepicker').datepicker({ format:'yyyy-mm-dd' });

							$('html, body').animate({ scrollTop: 0 });

						});

					});

					$('.ajax-add-modal-form').live('submit', function(e) {

						e.preventDefault();

					});

					$('.ajax-add-modal-save').live('click', function() {

						var model = $(this).attr('data-model');
						var url = $(this).attr('data-url');

						$.post(url, $('.ajax-add-modal-form').serialize(), function(data) {

							var id = parseInt(data);
							if(!isNaN(id)) {

								$('#modal > .modal').modal('hide').html('');
								$.getJSON(url + '/' + id, function(data) {

									var option = $('<option/>').attr('value', data.id).prop('selected', true).text(data.name);
									$('select[name="' + model + '"]').val('').append(option);

								});

							} else {

								var modal = $('#modal');
								modal.find('> .modal').modal('hide');
								modal.html(data).find('> .modal').modal({ keyboard:true, backdrop:false, show:true });
								modal.find('.datepicker').datepicker({ format:'yyyy-mm-dd' });

							}

						});

					});

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
						$.post("<?= route_url('post', 'App.Vendor.Admin.Controller.Admin', 'ajax_order'); ?>", data);

					}});

				});
			</script>
		<?php $this->end_section(); ?>

	</body>
</html>