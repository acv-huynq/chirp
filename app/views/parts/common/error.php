<div class="row">
	<div class="col-md-12">
		<?php if(count($error_message_list) > 0){ ?>
		<div class="alert alert-danger">
			<button class="close" data-dismiss="alert">&#215;</button>
			<ul>
			<?php foreach($error_message_list as $message) { ?>
				<li>
					<?php echo nl2br($message) ?>
				</li>
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
	</div>
</div>