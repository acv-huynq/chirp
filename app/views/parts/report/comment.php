<table class="table table-hover">
	<tbody>
			<?php foreach($comment_list as $data) { ?>
		<tr>
			<td>
				<ul id="commentListUl" class="commentList skinBorderList">
					<li>
						<div class="blogComment">
							<div class="commentHeader">
							<?= HTML::entities($data->comment_seq) ?>
							</div>
							<div class="commentBody"><?= HTML::entities($data->comment) ?></div>
							<div class="commentFooter text-right">
								<span class="commentAuthor"><?= HTML::entities($data->author) ?></span>
								<span> from </span>
								<span class="commentFrom"><?= HTML::entities($data->report_name) ?></span>
								<span class="commentTime skinWeakColor"><time><?= HTML::entities($data->create_timestamp) ?></time></span>
							</div>
						</div>
					</li>

				</ul>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
