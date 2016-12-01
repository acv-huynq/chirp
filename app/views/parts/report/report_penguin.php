<label for="report_title" class="label01">Report Title<span class="danger"> *</span><span>レポート件名</span></label>
<div class="label03">
	<input id="report_title" name="report_title" type="text" class="inputbox" value="<?= HTML::entities(Input::old('report_title',  $report_info->report_title)) ?>" maxlength="180" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
</div>
<div class="clearfix">
	<label for="type" class="label01">Line<span>回線</span></label>
	<div class="label02">
		<select id="line" name="line" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
			<option value=""></option>
			<?php foreach($line_list as $data) { ?>
				<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('line', $report_info->line) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="clearfix">
	<label for="first_contatct_date" class="label01">First Contact<span>入電日時</span></label>
	<div class="label02">
		<input id="first_contatct_date" name="first_contatct_date" type="text" class="inputbox datepicker" placeholder="YYYY/MM/DD" value="<?= HTML::entities(Input::old('first_contatct_date', $report_info->first_contatct_date)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?> />
	</div>
	<div class="label02">
		<input id="first_contact_time" name="first_contact_time" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('first_contact_time', $report_info->first_contact_time)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
	</div>
</div>
<div class="clearfix">
	<label for="last_contact_date" class="label01">Last Contact<span>最終通話日時</span></label>
	<div class="label02">
		<input id="last_contact_date" name="last_contact_date" type="text" class="inputbox datepicker" placeholder="YYYY/MM/DD" value="<?= HTML::entities(Input::old('last_contact_date', $report_info->last_contact_date)) ?>" maxlength="10" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
	</div>
	<div class="label02">
		<input id="last_contact_time" name="last_contact_time" type="text" class="inputbox" placeholder="HHMM(ex. 0700)" value="<?= HTML::entities(Input::old('last_contact_time', $report_info->last_contact_time)) ?>" maxlength="4" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
	</div>
</div>
<div class="clearfix">
	<label for="category" class="label01">Category<span>カテゴリ</span></label>
	<div class="label02">
		<select id="category" name="category" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
			<option value=""></option>
			<?php foreach($category_list as $data) { ?>
				<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('category', $report_info->category) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<label for="sub_category" class="label01">Sub Category<span>サブカテゴリ</span></label>
<div class="label02">
	<select id="sub_category" name="sub_category" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
		<option value=""></option>
		<?php foreach($sub_category_list as $data) { ?>
			<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('sub_category', $report_info->sub_category) == $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
		<?php } ?>
	</select>
</div>
<div class="label05">
	<div class="checkbox checkbox-inline form-inline text-right">
		<input id="sub_category_other_check" name="sub_category_other_check" type="checkbox" style="max-width: 60px;" <?php echo Input::old('sub_category_other',  $report_info->sub_category_other) == '' ? '' : 'checked="checked"' ?> <?= HTML::entities($role_manage_info->other_input_disabled) ?> />
		<label for="sub_category_other_check"></label>
	</div>
	<div>Other<br /><span>その他</span></div>
</div>
<div class="label02">
	<input id="sub_category_other" name="sub_category_other" type="text" class="inputbox"  placeholder="Alphabet only" value="<?= HTML::entities(Input::old('sub_category_other',  $report_info->sub_category_other)) ?>"  maxlength="70" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
</div>
<label for="contents" class="label01">Contents<span>クレーム内容</span></label>
<div class="label04">
	<textarea name="contents" id="contents" cols="100" rows="10" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" ><?= HTML::entities(Input::old('contents', $report_info->contents)) ?></textarea>
</div>
<label for="correspondence" class="label01">Correspondence<span>対応内容</span></label>
<div class="label04">
	<textarea name="correspondence" id="correspondence" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?>  maxlength="1500" ><?= HTML::entities(Input::old('correspondence', $report_info->correspondence)) ?></textarea>
</div>
