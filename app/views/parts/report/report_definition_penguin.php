<label for="type" class="label06">Station<span class="danger"> *</span><br /><span>起票部署</span></label>
<div class="label07">
	<select id="station" name="station" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($station_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('station', $report_info->station) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<label for="reported_by" class="label06">Reported By<span class="danger"> *</span><br /><span>起票者</span></label>
<div class="label07">
	<input id="reported_by" name="reported_by" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('reported_by', $report_info->reported_by)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
</div>
