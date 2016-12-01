		<label for="secret" class="label06">Own Department Only<br /><span>他部門非公開</span></label>
		<div class="label07">
			<div class="checkbox checkbox-inline">
				<input type="checkbox" id="own_department_only_flag" name="own_department_only_flag" <?php echo (Input::old('own_department_only_flag',$report_info->own_department_only_flag) === '1' || Input::old('own_department_only_flag',$report_info->own_department_only_flag) === 'on') ? 'checked="checked"' : '' ?> <?= HTML::entities($role_manage_info->other_input_disabled) ?>/>
				<label for="own_department_only_flag"></label>
			</div>
		</div>
