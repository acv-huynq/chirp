		<label for="Flight_Date" class="label01">Flight Date<br /><span>フライト日</span></label>
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
		<label for="etd" class="label01">STD<br /><span>出発時間</span></label>
		<div class="label02">
			<input id="std" name="std" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('std', $report_info->std)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?> />
		</div>
		<label for="sta" class="label01">STA<br /><span>到着時間</span></label>
		<div class="label02">
			<input id="sta" name="sta" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('sta', $report_info->sta)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
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
		<label for="dla_code" class="label01">#1 DLA Code<br /><span>遅延コード1</span></label>
		<div class="label02">
			<select id="dla_code" name="dla_code" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($dla_code_list as $data) { ?>
					<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('dla_code', $report_info->dla_code) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="dla_time" class="label01">#1 DLA Time<br /><span>遅延時間1</span></label>
		<div class="label02">
			<input id="dla_time" name="dla_time" type="text" class="inputbox02 dla_times" value="<?= HTML::entities(Input::old('dla_time', $report_info->dla_time)) ?>" style="text-align: right;" maxlength="3" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			<p class="text">min</p>
		</div>
		<label for="dla_code_2" class="label01">#2 DLA Code<br /><span>遅延コード2</span></label>
		<div class="label02">
			<select id="dla_code_2" name="dla_code_2" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($dla_code_list as $data) { ?>
					<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('dla_code_2', $report_info->dla_code_2) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="dla_time_2" class="label01">#2 DLA Time<br /><span>遅延時間2</span></label>
		<div class="label02">
			<input id="dla_time_2" name="dla_time_2" type="text" class="inputbox02 dla_times" value="<?= HTML::entities(Input::old('dla_time_2', $report_info->dla_time_2)) ?>" style="text-align: right;" maxlength="3" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			<p class="text">min</p>
		</div>
		<label for="dla_code_3" class="label01">#3 DLA Code<br /><span>遅延コード3</span></label>
		<div class="label02">
			<select id="dla_code_3" name="dla_code_3" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($dla_code_list as $data) { ?>
					<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('dla_code_3', $report_info->dla_code_3) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="dla_time_3" class="label01">#3 DLA Time<br /><span>遅延時間3</span></label>
		<div class="label02">
			<input id="dla_time_3" name="dla_time_3" type="text" class="inputbox02 dla_times" value="<?= HTML::entities(Input::old('dla_time_3', $report_info->dla_time_3)) ?>" style="text-align: right;" maxlength="3" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			<p class="text">min</p>
		</div>
		<label for="gate_spot" class="label01">Gate(Spot)<br /><span>ゲート（スポット）</span></label>
		<div class="label02">
			<input id="gate_spot" name="gate_spot" type="text" class="inputbox" value="<?= HTML::entities(Input::old('gate_spot', $report_info->gate_spot)) ?>" maxlength="8" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="dla_ttl" class="label01">DLA TTL<br /><span>遅延合計時間</span></label>
		<div class="label02">
			<input id="dla_ttl" name="dla_ttl" type="hidden" class="inputbox" value="<?= HTML::entities($report_info->dla_ttl) ?>" maxlength="3"/>
			<label id="dla_ttl_label" class="control-label"><?= HTML::entities($report_info->dla_ttl) ?></label>
			<p class="text">min</p>
		</div>
		<label for="pax_in" class="label01">PAX IN<br /><span>到着旅客数</span></label>
		<div class="label02">
			<input id="pax_in" name="pax_in" type="text" class="inputbox" value="<?= HTML::entities(Input::old('pax_in', $report_info->pax_in)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="pax_out" class="label01">PAX OUT<br /><span>出発旅客数</span></label>
		<div class="label02">
			<input id="pax_out" name="pax_out" type="text" class="inputbox" value="<?= HTML::entities(Input::old('pax_out', $report_info->pax_out)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>

<?php if($report_info->report_class == 3) {?>
		<label for="weather" class="label01">Weather<br /><span>天候</span></label>
		<div class="label02">
			<select id="weather" name="weather" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($weather_list as $data) { ?>
					<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('weather', $report_info->weather) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
<?php } ?>
