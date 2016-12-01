<?php

/**
 * HTML属性制御クラス
 * 画面・レポートステータス・ユーザー権限により属性をコントロールする
 */
class HtmlAttributeControl{

	protected $edit_button_hidden;
	protected $cancel_button_hidden;
	protected $save_button_hidden;
	protected $submit_button_hidden;
	protected $confirm_button_hidden;
	protected $close_button_hidden;
	protected $inquiry_button_hidden;
	protected $inquiry_save_button_hidden;
	protected $answer_save_button_hidden;
	protected $passback_button_hidden;
	protected $delete_button_hidden;
	protected $comment_button_hidden;
	protected $reservation_info_button_hidden;
	protected $pax_info_button_hidden;
	protected $send_mail_creator_hidden;
	protected $send_mail_administrator_group_hidden;
	protected $send_mail_approver_group_hidden;
	protected $send_mail_inquiry_from_administrator_group_hidden;
	protected $send_mail_inquiry_to_administrator_group_hidden;
	protected $inquire_to_hidden;


	/**
	 * コンストラクタ
	 */
	function __construct() {


	}

	protected function __set($key, $value){
		$this->$key = $value;
	}

	public function __get($key){
		return $this->$key;
	}
}
