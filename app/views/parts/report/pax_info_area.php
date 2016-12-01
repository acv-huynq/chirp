		<label for="firstname" class="label06">#1 First Name<br /><span>名前</span></label>
		<div class=label07>
			<input id="firstname" name="firstname" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('firstname', $report_info->firstname)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="lastname" class="label06">#1 Last Name<br /><span>苗字</span></label>
		<div class="label07">
			<input id="lastname" name="lastname" type="text" class="inputbox" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('lastname', $report_info->lastname)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label class="label06">#1 Gender<br /><span>性別</span></label>
		<div class="label07">
			<select id="title_rcd" name="title_rcd" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($gender_list as $data) { ?>
				<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('title_rcd', $report_info->title_rcd) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="birthday" class="label06">#1 Birthday<br /><span>生年月日</span></label>
		<div class="label07">
			<input id="birthday" name="birthday" type="text" class="inputbox" placeholder="YYYY/MM/DD" value="<?= HTML::entities(Input::old('birthday', $report_info->birthday)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="phone_number1" class="label06">#1 Phone Number<br /><span>電話番号</span></label>
<?php if($report_info->report_class != 1): ?>
		<div class="label07_2">
			<input id="phone_number1" name="phone_number1" type="text" class="inputbox" style="margin-bottom:10px;" value="<?= HTML::entities(Input::old('phone_number1', $report_info->phone_number1)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			<input id="phone_number2" name="phone_number2" type="text" class="inputbox" value="<?= HTML::entities(Input::old('phone_number2', $report_info->phone_number2)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="record_locator" class="label06">#1 PNR<br /><span>予約番号</span></label>
		<div class="label07" style="margin-bottom:50px;">
			<input id="record_locator" name="record_locator" type="text" class="inputbox" value="<?= HTML::entities(Input::old('record_locator', $report_info->record_locator)) ?>" maxlength="7" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
<?php else: ?>
		<div class="label07_2" style="margin-bottom:50px;">
			<input id="phone_number1" name="phone_number1" type="text" class="inputbox" style="margin-bottom:10px;" value="<?= HTML::entities(Input::old('phone_number1', $report_info->phone_number1)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			<input id="phone_number2" name="phone_number2" type="text" class="inputbox" value="<?= HTML::entities(Input::old('phone_number2', $report_info->phone_number2)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>

<?php endif;?>

<div class="row <?= HTML::entities($role_manage_info->pax_info_button_hidden) ?>">
	<div class="col-md-2 text-left" style="margin-left:12px; margin-bottom:15px;">
		<button type="button" class="btn btn-lgray btn-xs" data-toggle="collapse" data-target="#collapsePaxInfo">
			<span id="paxInfoIcon" class="glyphicon glyphicon-plus"></span>
			PAX Information
		</button>
	</div>
</div>

<div id="collapsePaxInfo" class="collapse">

			<label for="firstname_2" class="label06">#2 First Name<br /><span>名前</span></label>
			<div class="label07">
				<input id="firstname_2" name="firstname_2" type="text" class="inputbox additional-pax-info" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('firstname_2', $report_info->firstname_2)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label for="lastname_2" class="label06">#2 Last Name<br /><span>苗字</span></label>
			<div class="label07">
				<input id="lastname_2" name="lastname_2" type="text" class="inputbox additional-pax-info" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('lastname_2', $report_info->lastname_2)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label class="label06">#2 Gender<br /><span>性別</span></label>
			<div class="label07">
				<select id="title_rcd_2" name="title_rcd_2" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
					<option value=""></option>
					<?php foreach($gender_list as $data) { ?>
					<option class="additional-pax-info" value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('title_rcd_2', $report_info->title_rcd_2) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
					<?php } ?>
				</select>
			</div>
			<label for="birthday_2" class="label06">#2 Birthday<br /><span>生年月日</span></label>
			<div class="label07">
				<input id="type" name="birthday_2" type="text" class="inputbox additional-pax-info" placeholder="YYYY/MM/DD" value="<?= HTML::entities(Input::old('birthday_2', $report_info->birthday_2)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label for="phone_number1_2" class="label06">#2 Phone Number<br /><span>電話番号</span></label>
<?php if($report_info->report_class != 1): ?>
			<div class="label07_2">
				<input id="phone_number1_2" name="phone_number1_2" type="text" class="inputbox additional-pax-info" style="margin-bottom:10px;" value="<?= HTML::entities(Input::old('phone_number1_2', $report_info->phone_number1_2)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
				<input id="phone_number2_2" name="phone_number2_2" type="text" class="inputbox additional-pax-info" value="<?= HTML::entities(Input::old('phone_number2_2', $report_info->phone_number2_2)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label for="record_locator_2" class="label06">#2 PNR<br /><span>予約番号</span></label>
			<div class="label07" style="margin-bottom:50px;">
				<input id="record_locator_2" name="record_locator_2" type="text" class="inputbox additional-pax-info" value="<?= HTML::entities(Input::old('record_locator_2', $report_info->record_locator_2)) ?>" maxlength="7" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
<?php else: ?>
			<div class="label07_2" style="margin-bottom:50px;">
				<input id="phone_number1_2" name="phone_number1_2" type="text" class="inputbox additional-pax-info" style="margin-bottom:10px;" value="<?= HTML::entities(Input::old('phone_number1_2', $report_info->phone_number1_2)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
				<input id="phone_number2_2" name="phone_number2_2" type="text" class="inputbox additional-pax-info" value="<?= HTML::entities(Input::old('phone_number2_2', $report_info->phone_number2_2)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
<?php endif; ?>
			<label for="firstname_3" class="label06">#3 First Name<br /><span>名前</span></label>
			<div class="label07">
				<input id="firstname_3" name="firstname_3" type="text" class="inputbox additional-pax-info" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('firstname_3', $report_info->firstname_3)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label for="lastname_3" class="label06">#3 Last Name<br /><span>苗字</span></label>
			<div class="label07">
				<input id="lastname_3" name="lastname_3" type="text" class="inputbox additional-pax-info" placeholder="Alphabet only" value="<?= HTML::entities(Input::old('lastname_3', $report_info->lastname_3)) ?>" maxlength="40" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label class="label06">#3 Gender<br /><span>性別</span></label>
			<div class="label07">
				<select id="title_rcd_3" name="title_rcd_3" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
					<option value=""></option>
					<?php foreach($gender_list as $data) { ?>
					<option class="additional-pax-info" value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('title_rcd_3', $report_info->title_rcd_3) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
					<?php } ?>
				</select>
			</div>
			<label for="birthday_3" class="label06">#3 Birthday<br /><span>生年月日</span></label>
			<div class="label07">
				<input id="birthday_3" name="birthday_3" type="text" class="inputbox additional-pax-info" placeholder="YYYY/MM/DD" value="<?= Input::old('birthday_3', HTML::entities($report_info->birthday_3)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label for="phone_number1_3" class="label06">#3 Phone Number<br /><span>電話番号</span></label>

<?php if($report_info->report_class != 1): ?>
			<div class="label07_2">
				<input id="phone_number1_3" name="phone_number1_3" type="text" class="inputbox additional-pax-info" style="margin-bottom:10px;" value="<?= HTML::entities(Input::old('phone_number1_3', $report_info->phone_number1_3)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
				<input id="phone_number2_3" name="phone_number2_3" type="text" class="inputbox additional-pax-info" value="<?= HTML::entities(Input::old('phone_number2_3', $report_info->phone_number2_3)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
			<label for="record_locator_3" class="label06">#3 PNR<br /><span>予約番号</span></label>
			<div class="label07" style="margin-bottom:50px;">
				<input id="record_locator_3" name="record_locator_3" type="text" class="inputbox additional-pax-info" value="<?= HTML::entities(Input::old('record_locator_3', $report_info->record_locator_3)) ?>" maxlength="7" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
<?php else: ?>
			<div class="label07_2" style="margin-bottom:50px;">
				<input id="phone_number1_3" name="phone_number1_3" type="text" class="inputbox additional-pax-info" style="margin-bottom:10px;" value="<?= HTML::entities(Input::old('phone_number1_3', $report_info->phone_number1_3)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
				<input id="phone_number2_3" name="phone_number2_3" type="text" class="inputbox additional-pax-info" value="<?= HTML::entities(Input::old('phone_number2_3', $report_info->phone_number2_3)) ?>" maxlength="20" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
			</div>
<?php endif; ?>
	<div class="clearfix"></div>
</div>