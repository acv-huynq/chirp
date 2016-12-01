		<label for="phoenix_class" class="label06">Phoenix Class<br /><span>Phoenixカテゴリ</span></label>
		<div class="label07">
			<select id="phoenix_class" name="phoenix_class" class="inputbox" <?= HTML::entities($role_manage_info->other_input_disabled) ?>>
				<option value=""></option>
				<?php foreach($phoenix_class_list as $data) { ?>
				<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('phoenix_class', $report_info->phoenix_class) === $data->code2 ?  'selected="selected"' : '' ?>><?= HTML::entities($data->value2) ?></option>
				<?php } ?>
			</select>
		</div>
		<label for="phoenix_memo" class="label06">Phoenix Memo<br /><span>Phoenixメモ</span></label>
		<div class="label07_2">
			<textarea id="phoenix_memo" name="phoenix_memo" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea" <?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" placeholder="※black/special登録内容の補足記事欄
Additional explanation about black/special"><?= HTML::entities(Input::old('phoenix_memo', $report_info->phoenix_memo)) ?></textarea>
		</div>
