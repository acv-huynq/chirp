<?php if($report_info->report_no){ ?>
<script>
function answerRead(report_no, report_class, mode) {

	$('#answer_read').prop('disabled', true);

	$.ajax({
		type: 'POST',
		url: '/p/chirp/report/answer-read',
		dataType: 'text',
		data: {
			'_report_no':$('#_report_no').val(),
			'_report_class':$('#_report_class').val(),
			'_mode':$('#_mode').val(),
			'_modified':$('#_modified').val()
		}
	})
	// 通信成功
	.done(function(data, textStatus, jqXHR){
		// 正常
		if(data.length > 0 && data.match(/^\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2}$/)) {
			$('#report_modified').text(data + ' JST');
			alert('回答閲覧済に変更しました');
			$('#answer_read').hide();
			$('#_modified').val(data);

		// 排他エラー
		} else if (data.length > 0 && data === '0' ){
			alert('<?php echo Config::get('message.EXCLUSIVE_ERROR'); ?>');
		// 例外発生
		} else {
			alert('ステータスの変更に失敗しました');
			$('#answer_read').removeAttr('disabled');
		}

	})
	// 通信失敗
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert('ステータスの変更に失敗しました');
		$('#answer_read').removeAttr('disabled');
	})
	.always(function(data, textStatus, errorThrown){

	});
}
</script>
<div class="form-horizontal <?= HTML::entities($role_manage_info->comment_area_hidden) ?>">
	<label class="label06">Inquiry<br /><span>他部門照会</span></label>
	<div class="label07_2">
		<div style="word-wrap: break-word;max-height:300px;overflow: auto; margin-bottom: 5px;">
			<div id="comment" style="margin: 0px;padding: 0px"></div>
		</div>
		<div class="clearfix">
			<?php if($report_info->answer_read_button): ?>
			<button type="button" class="btn btn-lgray btn-xs viewed <?php echo $role_manage_info->answer_read_hidden ?>" onclick="answerRead();" id="answer_read">回答閲覧済</button>
			<?php endif; ?>
		</div>
		<button type="button" class="btn btn-pink pull-left <?php echo $role_manage_info->comment_button_hidden ?>" onclick="return showCommentDialog(this, '<?php echo $report_info->report_no ?>', '<?php echo $report_info->report_class ?>', '<?php echo $_mode ?>')">Comment</button>
	</div>
</div>
<?php } ?>

<?php if($_mode === 'inquiry'){ ?>
<label for="Send Mail" class="label06">Inquire To<br><span>照会先</span></label>
<div class="label07">
	<?php if($report_info->report_class != 1){ ?>
	<div class="checkbox checkbox-inline">
		<input id="penguin_inquiry_status" name="penguin_inquiry_status" type="checkbox" <?php echo(Input::old('penguin_inquiry_status','')) === 'on' ? 'checked="checked"' : '' ?> />
		<label for="penguin_inquiry_status">PENGUIN</label>
	</div>
	<?php } ?>
	<?php if($report_info->report_class != 2 && $report_info->report_class != 3){ ?>
	<div class="checkbox checkbox-inline">
		<input id="peregrine_inquiry_status" name="peregrine_inquiry_status" type="checkbox" <?php echo(Input::old('peregrine_inquiry_status','')) === 'on' ? 'checked="checked"' : '' ?> />
		<label for="peregrine_inquiry_status">PEREGRINE</label>
	</div>
	<?php } ?>
	<?php if($report_info->report_class != 4){ ?>
	<div class="checkbox checkbox-inline">
		<input id="peacock_inquiry_status" name="peacock_inquiry_status" type="checkbox" <?php echo(Input::old('peacock_inquiry_status','')) === 'on' ? 'checked="checked"' : '' ?>/>
		<label for="peacock_inquiry_status">PEACOCK</label>
	</div>
	<?php } ?>
</div>
<?php } ?>
