<div class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php $this->section('title'); ?><?php $this->end_section(); ?></h4>
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
	</div>
</div>