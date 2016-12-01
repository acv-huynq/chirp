		<label class="label01">Attachments<br /><span>添付ファイル</span></label>
		<div class="label04 <?= HTML::entities($role_manage_info->add_attach_file_button_hidden) ?>">
			<input type="file" id="attach_file_1" name="attach_file_1" data-attach-file-index="1" class="attache-file" style="display: none;">
			<button type="button" class="btn btn-lgray btn-xs add-attachfile"  onclick="$('#attach_file_1').click();">
	            Select
	        </button>
			<label id="dummy_file_1" class="control-label <?= HTML::entities($role_manage_info->add_attach_file_button_hidden) ?>" style="padding-left:10px;">ファイル未選択</label>
			<button type="button" class="btn btn-lgray btn-xs pull-right attache-file-clear" data-attach-file-index="1">
				<strong>×</strong>
			</button>
			<div class="clearfix"></div>
		</div>

		<div class="label04">
			<div class="<?= HTML::entities($role_manage_info->add_attach_file_button_hidden) ?>">
				<button type="button" class="btn btn-lgray btn-xs" data-toggle="collapse" data-target="#collapseAttachFile" >
					<span id="attachFileIcon" class="glyphicon glyphicon-plus"></span>
					 Attach File
				</button>

				<div id="collapseAttachFile" class="collapse <?= HTML::entities($role_manage_info->add_attach_file_button_hidden) ?>">

					<?php for($index = 2; $index <= 5;$index++) { ?>
						<input type="file" id="attach_file_<?php echo $index ?>" name="attach_file_<?php echo $index ?>" data-attach-file-index="<?php echo $index ?>" class="attache-file additional-attach-file" style="display: none;">
						<button type="button" class="btn btn-lgray btn-xs add-attachfile"  onclick="$('#attach_file_<?php echo $index ?>').click();">
				            Select
						</button>
						<label id="dummy_file_<?php echo $index ?>" class="control-label additional-attach-file-label" style="padding-left:10px;">ファイル未選択</label>
						<button type="button" class="btn btn-lgray btn-xs pull-right attache-file-clear" data-attach-file-index="<?php echo $index ?>">
							<strong>×</strong>
						</button>
						<div class="clearfix"></div>
					<?php } ?>
				</div>
			</div>

			<input type="hidden" id="attache_file_count" name="attache_file_count" value="<?php echo count($attach_file_list) ?>"/>
			<ul id="attache_file_list">
			<?php foreach($attach_file_list as $index => $data) { ?>
				<li class="attache_file">
					<a href="javascript:void(0)" onclick="downloadFile(document.forms.mainForm, '/p/chirp/report/download', <?= HTML::entities($data->file_seq) ?>);" ><?= HTML::entities($data->file_name) ?></a>
					<button type="button" class="btn btn-lgray btn-xs pull-right attache-file-delete <?= HTML::entities($role_manage_info->delete_attach_file_button_hidden) ?>" data-attach-file-index="<?= HTML::entities($index + 1) ?>" data-attach-file-seq="<?= HTML::entities($data->file_seq) ?>">
						<strong>×</strong>
					</button>
					<input type="hidden" id="delete_file_<?= HTML::entities($index + 1) ?>" name="delete_file_<?= HTML::entities($index + 1) ?>" value=""/>
				</li>
			<?php } ?>
			</ul>
		</div>
		<div class="clearfix"></div>
