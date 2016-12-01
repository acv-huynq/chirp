<div class="<?= HTML::entities($role_manage_info->send_mail_area_hidden) ?>">
	<div class="sendmail clearfix">
		<label for="Send Mail" class="label08">Send Mail<br /><span>照会メール送信</span></label>
		<div class="label08 <?= HTML::entities($role_manage_info->send_mail_creator_hidden) ?>">
			<div class="checkbox checkbox-inline">
				<input id="send_mail_creator" name="send_mail_creator" type="checkbox" <?php echo(Input::old('send_mail_creator','')) === 'on' ? 'checked="checked"' : '' ?> />
				<label for="send_mail_creator">Reporter<br />起票者</label>
			</div>
		</div>
		<div class="label08 <?= HTML::entities($role_manage_info->send_mail_administrator_group_hidden) ?>">
			<div class="checkbox checkbox-inline">
				<input id="send_mail_administrator_group" name="send_mail_administrator_group" type="checkbox" <?php echo(Input::old('send_mail_administrator_group','')) === 'on' ? 'checked="checked"' : '' ?> />
				<label for="send_mail_administrator_group">Peach Person in charge<br />Peach担当者</label>
			</div>
		</div>
		<div class="label08 <?= HTML::entities($role_manage_info->send_mail_approver_group_hidden) ?>">
			<div class="checkbox checkbox-inline">
				<input id="send_mail_approver_group" name="send_mail_approver_group" type="checkbox" <?php echo(Input::old('send_mail_approver_group','')) === 'on' ? 'checked="checked"' : '' ?> />
				<label for="send_mail_approver_group">Approver<br />承認者</label>
			</div>
		</div>
		<div class="label08 <?= HTML::entities($role_manage_info->send_mail_inquiry_from_administrator_group_hidden) ?>">
			<div class="checkbox checkbox-inline">
				<input id="send_mail_inquiry_from_administrator_group" name="send_mail_inquiry_from_administrator_group" type="checkbox" <?php echo(Input::old('send_mail_inquiry_from_administrator_group','')) === 'on' ? 'checked="checked"' : (count($error_message_list) > 0 ? '' : HTML::entities($role_manage_info->send_mail_inquiry_from_administrator_group_checked)) ?> />
				<label for="send_mail_inquiry_from_administrator_group">Inquire From<br />照会元</label>
			</div>
		</div>
		<div class="label08 <?= HTML::entities($role_manage_info->send_mail_inquiry_to_administrator_group_hidden) ?>">
			<div class="checkbox checkbox-inline">
				<input id="send_mail_inquiry_to_administrator_group" name="send_mail_inquiry_to_administrator_group" type="checkbox" <?php echo(Input::old('send_mail_inquiry_to_administrator_group','')) === 'on' ? 'checked="checked"' : '' ?> />
				<label for="send_mail_inquiry_to_administrator_group">Inquire To<br />照会先</label>
			</div>
		</div>
	</div>
</div>