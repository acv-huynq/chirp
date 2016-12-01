<?php

class BaseController extends Controller {

	/**
	 * 認証要求フラグ(認証が必要な場合はtrue)
	 */
	protected $requireAuth = true;

	/**
	 * ユーザー情報
	 */
	protected $user;

	/**
	 * エラーメッセージの一覧
	 * @var unknown
	 */
	protected $error_message_list;

	/**
	 * コンストラクタ
	 */
	function __construct() {

		$this->beforeFilter(function()
		{
			$this->error_message_list = Session::get('error_message_list');
			if($this->error_message_list == null){
				$this->error_message_list = [];
			}

			if($this->requireAuth){

				// ログイン済みの場合
				if($this -> isLogin() ){

					// ユーザー情報取得
					$this->user = unserialize(Session::get('SESSION_KEY_CHIRP_USER'));

				// ログインしてない場合
				}else{
					return View::make('timeout');
				}
			}
		});
	}

	/**
	 * コントローラーにより使用されるレイアウトの設定.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * ログイン済みチェック
	 */
	protected function isLogin(){
		return Session::has('SESSION_KEY_CHIRP_USER');
	}

	/**
	 * エラー存在チェック
	 */
	protected function hasError(){
		return count($this->error_message_list) > 0;
	}

	/**
	 * 起票者かどうかチェック
	 * @return boolean チェック結果
	 */
	protected function isCreator(){
		return intVal($this->user->userInfo->user_role) === Config::get('const.USER_ROLE.REPORTER');
	}
}
