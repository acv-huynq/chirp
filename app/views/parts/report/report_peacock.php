		<label for="report_title" class="label01">Report Title<span class="danger"> *</span><br /><span>レポート件名</span></label>
		<div class="label03">
			<input id="report_title" name="report_title" type="text" class="inputbox" value="<?= HTML::entities(Input::old('report_title',  $report_info->report_title)) ?>" maxlength="180" <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
		</div>
		<label for="reporting_date" class="label01">Reporting Date<br /><span>事象発生日</span></label>
		<label id="reporting_date" class="label02"><?= HTML::entities($report_info->reporting_date) ?></label>
		<div class="clearfix"></div>

<div id="category"></div>


		<label for="contents" class="label01">Contents<br /><span>内容</span></label>
		<div class="label04">
			<textarea name="contents" id="contents" cols="100" rows="10" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" ><?= HTML::entities(Input::old('contents', $report_info->contents)) ?></textarea>
		</div>
		<label for="staff_comment" class="label01">Staff Comment<br /><span>スタッフ補記</span></label>
		<div class="label04">
			<textarea name="staff_comment" id="staff_comment" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" ><?= HTML::entities(Input::old('staff_comment', $report_info->staff_comment)) ?></textarea>
		</div>
