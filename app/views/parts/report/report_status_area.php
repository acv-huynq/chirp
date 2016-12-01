		<label class="label06">Report No<br /><span>レポート番号</span></label>
		<label class="label07"><?= HTML::entities($report_info->report_no) ?></label>
		<label class="label06">Report Status<br /><span>レポートステータス</span></label>
		<label class="label07"><?= HTML::entities($report_info->report_status_name) ?></label>

		<label class="label06">Created<br /><span>作成日</span></label>
		<label class="label07"><?= HTML::entities($report_info->create_timestamp) ?> JST</label>
		<label class="label06">Modified<br /><span>更新日</span></label>
		<label class="label07" id="report_modified"><?= HTML::entities($report_info->update_timestamp) ?> JST</label>
