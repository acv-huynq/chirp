<div class="row">
	<div class="form-group clearfix">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<button type="button" class="btn btn-pink <?php echo $role_manage_info->cancel_button_hidden ?>" onclick="execCancel(this.form, '/p/chirp/report/cancel','レポートの編集を破棄します。よろしいですか？')">&nbsp;Cancel&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->delete_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/delete','レポートを削除します。よろしいですか？')">&nbsp;Delete&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->edit_button_hidden ?>" onclick="exec(this.form, '/p/chirp/report/edit')">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->inquiry_button_hidden ?>" onclick="exec(this.form, '/p/chirp/report/inquiry')">Inquiry</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->save_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/save','レポートを保存します。よろしいですか？')">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->submit_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/submit','レポートを提出します。よろしいですか？')">&nbsp;Submit&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->passback_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/passback','レポートを差戻します。よろしいですか？')">Passback</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->confirm_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/confirm','レポートを確認します。よろしいですか？')">Confirm</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->close_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/close','レポートを承認します。よろしいですか？')">&nbsp;Close&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->inquiry_save_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/inquiry-save','レポートを照会します。よろしいですか？')">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
			<button type="button" class="btn btn-pink col-md-offset-1 <?php echo $role_manage_info->answer_save_button_hidden ?>" onclick="execWithConfirm(this.form, '/p/chirp/report/answer-to-inquiry','レポートを回答します。よろしいですか？')">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
		</div>
	</div>
</div>