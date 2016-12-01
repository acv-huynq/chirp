		<label for="free_comment" class="label01">Remarks<span>備考</span></label>
		<div class="label04">
			<textarea id="free_comment" name="free_comment" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->remarks_disabled) ?> maxlength="1500"><?= HTML::entities(Input::old('free_comment', $report_info->free_comment)) ?></textarea>
		</div>
