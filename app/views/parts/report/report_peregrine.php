<script>

var riskLevel = {
		'Insignificant'	:
		{
			'1':'Level A',
			'2':'Level A',
			'3':'Level A',
			'4':'Level B'
		},
		'Minor'			:
		{
			'1':'Level A',
			'2':'Level B',
			'3':'Level B',
			'4':'Level C'
		},
		'Moderate'		:
		{
			'1':'Level A',
			'2':'Level C',
			'3':'Level D',
			'4':'Level D'
		},
		'Major'			:
		{
			'1':'Level B',
			'2':'Level D',
			'3':'Level D',
			'4':'Level D'
		},
	};

var dayOfWeek = ['SUN','MON','TUE','WED','THU','FRI','SAT'];


function calculateRisk(){

	var result = ''

	var influence_on_safety = $('#influence_on_safety').val();
	var frequency =  $('#frequency').val();

	if(influence_on_safety != '' && frequency != ''){

		var risk = riskLevel[influence_on_safety][frequency];

		if(typeof risk !== "undefined"){
			result = risk;
		}
	}
	$('#assessment_level').text(result);
	$('#assessment').val(result);
}

function calculateDLATTL(){

	var sum = 0;
	var dla_time = parseInt($('#dla_time').val());
	var dla_time_2 = parseInt($('#dla_time_2').val());
	var dla_time_3 = parseInt($('#dla_time_3').val());

	if(dla_time != '' && !isNaN(dla_time)){
		sum += dla_time;
	}
	if(dla_time_2 != '' && !isNaN(dla_time_2)){
		sum += dla_time_2;
	}
	if(dla_time_3 != '' && !isNaN(dla_time_3)){
		sum += dla_time_3;
	}
	$('#dla_ttl_label').text(sum);
	$('#dla_ttl').val(sum);
}

function calculateDayOfWeek(obj){

	$('#day_of_week_label').text('');
	$('#day_of_week').val('');


	var d = new Date($(obj).val());
	var result = dayOfWeek[d.getDay()];

	$('#day_of_week_label').text(result);
	$('#day_of_week').val(result);
}

$(function(){

	$(window).load(function () {
		calculateRisk();
		calculateDLATTL();
		calculateDayOfWeek('#reporting_date');
	});


	$('#reporting_date').on('change', function(){
		calculateDayOfWeek(this);
	});

	$('#influence_on_safety').on('change', function(){
		calculateRisk();
	});

	$('#frequency').on('change', function(){
		calculateRisk();
	});

	$('.dla_times').on('change', function(){
		calculateDLATTL();
	});

});
</script>

<label for="report_title" class="label01">Report Title<span class="danger"> *</span><br /><span>レポート件名</span></label>
<div class="label03">
	<input id="report_title" name="report_title" type="text" class="inputbox" placeholder="Area/Category/Flight No" value="<?= HTML::entities(Input::old('report_title',  $report_info->report_title)) ?>" maxlength="180" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
</div>
<label for="reporting_date" class="label01">Reporting Date<br /><span>報告日</span></label>
<div class="label02">
	<input id="reporting_date" name="reporting_date" type="text" class="inputbox datepicker" value="<?= HTML::entities(Input::old('reporting_date',  $report_info->reporting_date)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
</div>
<div class="label02">
	<div class="row">
		<input type="hidden" id="day_of_week" name="day_of_week" value="<?= HTML::entities($report_info->day_of_week) ?>" />
		<label id="day_of_week_label" class="form-control-static text-left col-md-2"><?= HTML::entities($report_info->day_of_week) ?></label>
	</div>
</div>
<div class="clearfix"></div>
<label for="area" class="label01">Area<br /><span>場所</span></label>
<div class="label02">
	<select id="area" name="area" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($area_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('area', $report_info->area) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<div class="clearfix"></div>
<label for="category" class="label01">Category<br /><span>区分</span></label>
<div class="label02">
	<select id="category" name="category" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($category_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('category', $report_info->category) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<div class="clearfix"></div>
<label for="contents" class="label01">Contents<br /><span>報告内容</span></label>
<div class="label04">
	<textarea name="contents" id="contents" cols="100" rows="10" class="inputbox03 no-resize-horizontal-textarea" maxlength="1500" <?= HTML::entities($role_manage_info->other_input_disabled) ?>><?= HTML::entities(Input::old('contents', $report_info->contents)) ?></textarea>
</div>
<label for="factor" class="label01">Factor<br /><span>要因</span></label>
<div class="label02">
	<select id="factor" name="factor" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($factor_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('factor', $report_info->factor) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<div class="clearfix"></div>
<label for="staff_comment" class="label01">Measures to Prevent Recurrence<br /><span>再発防止策</span></label>
<div class="label04">
	<textarea name="measures_to_revent_recurrence" id="measures_to_revent_recurrence" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" ><?= HTML::entities(Input::old('measures_to_revent_recurrence', $report_info->measures_to_revent_recurrence)) ?></textarea>
</div>
<label for="staff_comment" class="label01">Staff Comment<br /><span>担当者記入欄</span></label>
<div class="label04">
	<textarea name="staff_comment" id="staff_comment" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" maxlength="1500" <?= HTML::entities($role_manage_info->other_input_disabled) ?>><?= HTML::entities(Input::old('staff_comment', $report_info->staff_comment)) ?></textarea>
</div>
<label for="approve_comment" class="label01">Approver Comment<br /><span>承認者記入欄</span></label>
<div class="label04">
	<textarea name="approve_comment" id="approve_comment" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" ><?= HTML::entities(Input::old('approve_comment', $report_info->approve_comment)) ?></textarea>
</div>
<div class="clearfix"></div>
<label class="label01_2">Risk Assessment<br /><span>リスク評価<br>※リスク評価員記入欄<br>For risk assessment member only</span></label>
<label for="influence_on_safety" class="label05">Influence on Safety<br /><span>安全への影響度</span></label>
<div class="label05_2">
	<select id="influence_on_safety" name="influence_on_safety" class="inputbox" style="color: #000;" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($influence_on_safety_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('influence_on_safety', $report_info->influence_on_safety) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<label for="frequency" class="label05">Frequency<br /><span>発生頻度</span></label>
<div class="label05_2">
	<select id="frequency" name="frequency" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($frequency_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('frequency', $report_info->frequency) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<div class="row">
	<input type="hidden" id="assessment" name="assessment" value="<?= HTML::entities($report_info->assessment) ?>" />
	<label id="assessment_label" class="label05">Assessment<br /><span>評価</span></label>
	<label id="assessment_level" class="label05"><?= HTML::entities($report_info->assessment) ?></label>
</div>
