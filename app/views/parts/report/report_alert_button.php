<?php if(unserialize(Session::get('SESSION_KEY_CHIRP_USER'))->userInfo->report_name == 'PEREGRINE'): ?>
<script>
function alertButton() {

	$('button').prop("disabled", true);
	$('a').addClass("avoid-clicks");

	$.ajax({
		type: 'POST',
		url: '/p/chirp/report/alert-setting',
		dataType: 'text',
		data: {
			'_report_no':$('#_report_no').val(),
			'_report_class':$('#_report_class').val(),
			'_mode':$('#_mode').val(),
			'_report_alert':$('#_report_alert').val()
		}
	})
	// 通信成功
	.done(function(data, textStatus, jqXHR){
		// 正常
		if(data.length > 0 && data === "1") {
			if($('input[name="report_alert"]').val() == '0') {
				alert('アラート設定しました');
				$('#alert_me').removeClass('btn-lgray')
							.addClass('btn-pink');
				$('input[name="report_alert"]').val(1);
			} else {
				alert('アラート設定を解除しました。');
				$('#alert_me').removeClass('btn-pink')
							.addClass('btn-lgray');
				$('input[name="report_alert"]').val(0);
			}
		// 例外発生
		} else {
			// 2016/4/4 #12 何を以て排他エラーとしているのかわからない為、コメントとする。
			// alert('<?php echo Config::get('message.EXCLUSIVE_ERROR'); ?>');
			alert('ステータスの変更に失敗しました');
		}
	})
	// 通信失敗
	.fail(function(jqXHR, textStatus, errorThrown) {
		alert('ステータスの変更に失敗しました');
	})
	.always(function(data, textStatus, errorThrown){
		$('button').prop("disabled", false);
		$('a').removeClass("avoid-clicks");
	});

}
</script>

			<div class="row" style="margin-bottom:10px;">
				<div class="col-md-12 <?=$role_manage_info->report_alert_hidden; ?>">
					<input type="hidden" name="report_alert" id="_report_alert" value="<?= $report_alert ?>">
					<button type="button" id="alert_me" class="btn <?php if($report_alert): ?>btn-pink<?php else: ?>btn-lgray<?php endif; ?> btn-xs pull-right alert_button" onclick="alertButton();">Alert Me</button>
				</div>
			</div>
<?php endif; ?>