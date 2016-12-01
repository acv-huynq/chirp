<?php if($report_info->report_class == 1){ ?>
<div class="clearfix">
	<label for="record_locator" class="label01">#1 PNR<span>予約番号</span></label>
	<div class="label02">
		<input id="record_locator" name="record_locator" type="text" class="form-control" value="<?= HTML::entities(Input::old('record_locator', $report_info->record_locator)) ?>"  maxlength="7" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
	</div>
</div>
<div class="clearfix">
	<label for="departure_date" class="label01 datepicker">#1 Flight Date<span>フライト日</span></label>
	<div class="label02">
		<input id="departure_date" name="departure_date" type="text" class="form-control datepicker" value="<?= HTML::entities(Input::old('departure_date', $report_info->departure_date)) ?>"  maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
	</div>
</div>
<div class="clearfix">
	<label for="flight_number" class="label01">#1 Flight No<span>便名　※MMxxxx(ex. MM0001)</span></label>
	<div class="label02">
		<input id="flight_number" name="flight_number" type="text" class="form-control" value="<?= HTML::entities(Input::old('flight_number', $report_info->flight_number)) ?>"  maxlength="6" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
	</div>
</div>

<div class="row <?= HTML::entities($role_manage_info->reservation_info_button_hidden) ?>">
	<div class="col-md-2 text-left" style="margin-left:12px; margin-bottom:15px;">
		<button type="button" class="btn btn-lgray btn-xs" data-toggle="collapse" data-target="#collapseResavationInfo">
			<span id="resavationInfoIcon" class="glyphicon glyphicon-plus"></span>
			 Reservation Information
		</button>
	</div>
</div>

<div id="collapseResavationInfo" class="collapse">

	<div class="clearfix">
		<label for="record_locator_2" class="label01">#2 PNR<span>予約番号</span></label>
		<div class="label02">
			<input id="record_locator_2" name="record_locator_2" type="text" class="form-control additional-resavation-info" value="<?= HTML::entities(Input::old('record_locator_2', $report_info->record_locator_2)) ?>"  maxlength="7" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
	</div>
	<div class="clearfix">
		<label for="departure_date_2" class="label01 datepicker">#2 Flight Date<span>フライト日</span></label>
		<div class="label02">
			<input id="departure_date_2" name="departure_date_2" type="text" class="form-control additional-resavation-info datepicker" value="<?= HTML::entities(Input::old('departure_date_2', $report_info->departure_date_2)) ?>"  maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
	</div>
	<div class="clearfix">
		<label for="flight_number_2" class="label01">#2 Flight No<span>便名　※MMxxxx(ex. MM0001)</span></label>
		<div class="label02">
			<input id="flight_number_2" name="flight_number_2" type="text" class="form-control additional-resavation-info" value="<?= HTML::entities(Input::old('flight_number_2', $report_info->flight_number_2)) ?>"  maxlength="6" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
	</div>

</div>
<?php  } ?>