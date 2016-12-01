<script>
$(function(){

	$('#departure_date').on('change', function(){

		$('#reporting_date').text('');


		var array = $(this).val().split('/');
		if(array.length != 3){
			return;
		}

		var date = new Date($(this).val());

		if( date.getFullYear() == parseInt(array[0]) &&
			date.getMonth()+1 == parseInt(array[1]) &&
			date.getDate() == parseInt(array[2])){

			$('#reporting_date').text($(this).val());
		}

	});

});
</script>

		<label for="departure_date" class="label01">Flight Date<br /><span>フライト日</span></label>
		<div class="label02">
			<input type="text" id="departure_date" name="departure_date" class="inputbox datepicker" placeholder="YYYY/MM/DD" value="<?= HTML::entities(Input::old('departure_date',$report_info->departure_date)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="Flight_No" class="label01">Flight No<br /><span>便名　※MMXXXX(ex. MM0001)</span></label>
		<div class="label02">
			<input type="text" id="flight_number" name="flight_number" class="inputbox" placeholder="MMXXXX(ex. MM0001)" value="<?= HTML::entities(Input::old('flight_number', $report_info->flight_number)) ?>" maxlength="6" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="Ship_No" class="label01">Ship No<br /><span>機番</span></label>
		<div class="label02">
			<select id="ship_no" name="ship_no" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($ship_no_list as $data) { ?>
						<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('ship_no', $report_info->ship_no) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="Sector" class="label01">Sector<br /><span>区間</span></label>
		<div class="label02">
			<select id="origin_rcd" name="origin_rcd" class="inputbox02" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($sector_list as $data) { ?>
							<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('origin_rcd', $report_info->origin_rcd) === $data->code2 ? 'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
			<p class="form-control-static">→</p>
			<select id="destination_rcd" name="destination_rcd" class="inputbox02" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($sector_list as $data) { ?>
							<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('destination_rcd', $report_info->destination_rcd) === $data->code2 ? 'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="etd" class="label01">ETD<br /><span>出発予定時間</span></label>
		<div class="label02">
			<input id="etd" name="etd" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('etd', $report_info->etd)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?> />
		</div>
		<label for="eta" class="label01">ETA<br /><span>到着予定時間</span></label>
		<div class="label02">
			<input id="eta" name="eta" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('eta', $report_info->eta)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="atd" class="label01">ATD<br /><span>実出発時間</span></label>
		<div class="label02">
			<input id="atd" name="atd" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('atd', $report_info->atd)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="ata" class="label01">ATA<br /><span>実到着時間</span></label>
		<div class="label02">
			<input id="ata" name="ata" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('ata', $report_info->ata)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="pax_onboard" class="label01">PAX Onboard<br /><span>旅客数</span></label>
		<div class="label02">
			<input id="pax_onboard" name="pax_onboard" type="text" class="inputbox" value="<?= HTML::entities(Input::old('pax_onboard', $report_info->pax_onboard)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="pax_detail" class="label01_2">PAX Remarks Code & Seat No<br /><span>配慮を要する旅客のコード・座席番号</span></label>
		<div class="label02">
			<input id="pax_detail" name="pax_detail" type="text" class="inputbox" value="<?= HTML::entities(Input::old('pax_detail', $report_info->pax_detail)) ?>" maxlength="15" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<div class="clearfix"></div>
		<label for="crew_cp" class="label01">CREW CP<br /><span>CP氏名</span></label>
		<div class="label02">
			<input id="crew_cp" name="crew_cp" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('crew_cp', $report_info->crew_cp)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="crew_cap" class="label01">CREW CAP<br /><span>CAP氏名</span></label>
		<div class="label02">
			<input id="crew_cap" name="crew_cap" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('crew_cap', $report_info->crew_cap)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="crew_r1" class="label01">CREW R1<br /><span>R1氏名</span></label>
		<div class="label02">
			<input id="crew_r1" name="crew_r1" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('crew_r1', $report_info->crew_r1)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="crew_l2" class="label01">CREW L2<br /><span>L2氏名</span></label>
		<div class="label02">
			<input id="crew_l2" name="crew_l2" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('crew_l2', $report_info->crew_l2)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="crew_r2" class="label01">CREW R2<br /><span>R2氏名</span></label>
		<div class="label02">
			<input id="crew_r2" name="crew_r2" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('crew_r2', $report_info->crew_r2)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>


