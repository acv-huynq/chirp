<?php if(count($category_list)){ ?>
<div id="category_area" class="form-horizontal">
	<label class="label01">Category<br /><span>カテゴリ</span></label>
	<input type="hidden" id="category_list_count" name="category_list_count" value="<?php echo count($category_list)?>"/>
	<div class="label04">
	<?php foreach($category_list as $index =>$data) { ?>
	<div class="col-md-6">
		<div class="checkbox checkbox-inline">
			<?php
			$check_value = null;

			foreach ($select_categoly_info as $categoly_info ){

				if($categoly_info->report_type == Input::old('report_type',$report_info->report_type) &&
				   $categoly_info->category == $data->code2){
					$check_value = 'on';
					break;
				}
			}
			?>
			<input id="category_<?= HTML::entities($index + 1) ?>" name="category_<?= HTML::entities($index + 1) ?>" type="checkbox" <?php echo Input::old('category_' . $index + 1, $check_value) != null ? 'checked="checked"' : '' ?> value="<?= HTML::entities($data->code2) ?>" <?= HTML::entities($role_manage_info->other_input_disabled) ?> />
			<label for="category_<?= HTML::entities($index + 1) ?>"></label>
		</div>
		<?= HTML::entities($data->code2 . ' ' . $data->value2) ?>
	</div>
	<?php } ?>
	</div>
<?php if($category_option === 'MR'){ ?>
	<label for="mr" class="label01">MR<span>メディカルレポート</span></label>
	<div class="label04">
		<textarea name="mr" id="mr" cols="100" rows="5" class="inputbox03 no-resize-horizontal-textarea"<?= HTML::entities($role_manage_info->other_input_disabled) ?> maxlength="1500" placeholder="※救急車要請・ドクターコールの有無・非常用装備品・医療医薬品の使用状況を記入
Ambulance Request ・Doctor call・ Use of Emergency Equipment,　Medical Equipment"><?= HTML::entities(Input::old('mr', $report_info->mr)) ?></textarea>
	</div>

<?php } ?>
</div>
<?php } ?>
