		<label for="type" class="label06">Report Type<span class="danger"> *</span><span>レポート種別</span></label>
		<div class="label07">
			<select id="report_type" name="report_type" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($report_type_list as $data) { ?>
					<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('report_type', $report_info->report_type) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="flight_report_no" class="label06">Flight Report No<span>フライトレポート番号</span></label>
		<div class="label07">
			<input type="text" name="flight_report_no" id="flight_report_no" class="inputbox" value="<?= HTML::entities(Input::old('flight_report_no', $report_info->flight_report_no)) ?>" maxlength="6" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		</div>
		<label for="reported_by" class="label06">Reported By<span class="danger"> *</span><span>起票者</span></label>
		<div class="label07">
			<input id="reported_by" name="reported_by" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('reported_by', $report_info->reported_by)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="added_by" class="label06">Added By<span>スタッフ補記担当</span></label>
		<div class="label07">
			<input id="added_by" name="added_by" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('added_by', $report_info->added_by)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?> />
		</div>

