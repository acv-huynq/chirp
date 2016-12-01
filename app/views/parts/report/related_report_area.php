		<label for="related_report_no" class="label01_2">Related Report<br><span>関連レポート<br />※このレポートに関連する
Report Noを記載して下さい<br />
Related report No to this report.</span></label>
		<div class="label04">

			<div class="label02">
				<input id="related_report_no" name="related_report_no" type="text" class="inputbox" placeholder="ex. CTYO2015-00001" value="<?= HTML::entities(Input::old('related_report_no', $report_info->related_report_no)) ?>" maxlength="14" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<div class="row col-md-1 text-left report_link">
				<?php if($_mode != 'relation' && $report_info->related_report_class){?>
					<a href="javascript:void(0)" onclick="selectRelatedReport('<?= HTML::entities($report_info->related_report_no) ?>', '<?= HTML::entities($report_info->related_report_class) ?>')"><span class="glyphicon glyphicon-file" style="font-size:150%"></span></a>
				<?php } ?>
			</div>
			<div class="label02">
	    		<input id="related_report_no_2" name="related_report_no_2" type="text" class="inputbox" placeholder="ex. NKIX2015-00001" value="<?= HTML::entities(Input::old('related_report_no_2', $report_info->related_report_no_2)) ?>" maxlength="14" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<div class="row col-md-1 text-left report_link">
				<?php if($_mode != 'relation' && $report_info->related_report_class_2){?>
					<a href="javascript:void(0)" onclick="selectRelatedReport('<?= HTML::entities($report_info->related_report_no_2) ?>', '<?= HTML::entities($report_info->related_report_class_2) ?>')"><span class="glyphicon glyphicon-file" style="font-size:150%"></span></a>
				<?php } ?>
			</div>

			<div class="clearfix"></div>
			<p class="<?= HTML::entities($role_manage_info->related_report_area_hidden) ?>">[Reference reports of other department / 参考他部門レポート]</p>
			<ul class="<?= HTML::entities($role_manage_info->related_report_area_hidden) ?>" id="rerated_report_list">
				<?php foreach($related_report_list as $data) { ?>
					<li class="rerated_report">
						<div class="row col-md-12">
							<?php if($_mode == 'relation'){?>
								<p><?= HTML::entities($data->report_no) ?>　<?= HTML::entities($data->report_title) ?></p>
							<?php }else{?>
								<a href="javascript:void(0)" onclick="selectRelatedReport('<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_class) ?>')"><?= HTML::entities($data->report_no) ?>　<?= HTML::entities($data->report_title) ?></a>
							<?php } ?>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>

		<div class="clearfix"></div>
<script>

function selectInputRelatedReport(id){

	var value = $(id).val();
	if(value == ''){
		return false;
	}
	selectRelatedReport($(id).val(), null);
}

function selectRelatedReport(report_no, report_class){


	$('button').prop("disabled", true);
	$('a').addClass("avoid-clicks");
	var form = document.forms.mainForm;
	form.setAttribute("action", '/p/chirp/report/related-report');
	var data = {
			'related_report_no':report_no,
			'related_report_class':report_class
	};

	for (var paramName in data) {
		var input = document.createElement('input');
		input.setAttribute('type', 'hidden');
		input.setAttribute('name', paramName);
		input.setAttribute('value', data[paramName]);
		form.appendChild(input);
	}

	form.submit();

/*
	if (modeValue == "edit" ||
		modeValue == "confirm" ||
		modeValue == "close") {
		var form = document.forms.mainForm;
		form.setAttribute("action", '/p/chirp/report/related-report');
		var data = {
				'related_report_no':report_no,
				'related_report_class':report_class
		};

		for (var paramName in data) {
			var input = document.createElement('input');
			input.setAttribute('type', 'hidden');
			input.setAttribute('name', paramName);
			input.setAttribute('value', data[paramName]);
			form.appendChild(input);
		}

		form.submit();

	} else {

		// フォーム生成
		var form = document.createElement("form");
		form.setAttribute("action", '/p/chirp/report/related-report');
		form.setAttribute("method", "post");
		form.style.display = "none";
		document.body.appendChild(form);

		var data = {
				'_mode': $('#_mode').val(),
				'_report_no': $('#_report_no').val(),
				'_report_class':$('#_report_class').val(),
				'related_report_no':report_no,
				'related_report_class':report_class
		};

		for (var paramName in data) {
			var input = document.createElement('input');
			input.setAttribute('type', 'hidden');
			input.setAttribute('name', paramName);
			input.setAttribute('value', data[paramName]);
			form.appendChild(input);
		}
		form.submit();
	}
	*/
}
</script>