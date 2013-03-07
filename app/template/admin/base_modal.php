<div class="modal">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3><?php $this->section('title'); ?><?php $this->end_section(); ?></h3>
	</div>
	
	<div class="modal-body">
		<?php $this->section('content'); ?>

			<!-- Defualt Content -->

		<?php $this->end_section(); ?>
	</div>
	
	<div class="modal-footer">
		<?php $this->section('controls'); ?>

			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

		<?php $this->end_section(); ?>
	</div>

</div>