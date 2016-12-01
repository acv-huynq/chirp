<?php

/**
 * ログイン画面
 */
class LoginController extends BaseController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		$this->requireAuth = false;
		parent::__construct();
	}

	/**
	 * ログイン画面表示
	 */
	function getIndex() {

		return View::make('login')
			->nest('parts_common_header', 'parts.common.header',['header_title' => '', 'login_button_hidden' => 'hidden-element'])
			->nest('parts_common_error', 'parts.common.error',['error_message_list' => Session::get('error_message_list')]);
	}

	/**
	 * ログイン処理
	 */
	function postLogin(){

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				Input::get('login_id'),
				'ログイン画面',
				'ログイン',
				'');


		// TESTロジック START
// 		$userInfo = DataManager::getUserInfo(Input::get("login_id"));

// 		if( ! $userInfo ){
// 				return Redirect::to('/')
// 				->with('error_message_list', ['User Name／Passwordの認証に失敗しました。']);
// 			}


// 			$user = new ChirpUser($userInfo);



// 			Session::put('SESSION_KEY_CHIRP_USER', serialize($user));

// 		return Redirect::to('/top');
		// TESTロジック END




		// 入力チェック
		if(CommonCheckLogic::isEmpty(Input::get('login_id'))) {
			$this->error_message_list[] = 'User Nameは必須です。';
		}
		if(CommonCheckLogic::isEmpty(Input::get('password'))) {
			$this->error_message_list[] = 'PassWordは必須です。';
		}

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/')
			->with('error_message_list',$this->error_message_list);
		}

		// LDAP認証
//		if(LdapAuth::auth(Input::get("login_id"), Input::get("password"))){
		if(true){

			// ユーザー情報を取得
			$userInfo = DataManager::getUserInfo(Input::get("login_id"));

			if($userInfo ){

				// ユーザーオブジェクトをセッションに格納
				$user = new ChirpUser($userInfo);
				Session::put('SESSION_KEY_CHIRP_USER', serialize($user));

			}else{
				$this->error_message_list[] = 'chirpアカウントが存在しません。';
			}

		}else{
			$this->error_message_list[] = 'User Name／Passwordの認証に失敗しました。';
		}


		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/')
				->with('error_message_list',$this->error_message_list);
		}
		return Redirect::to('/top');
	}

	/**
	 * ログアウト処理
	 */
	function postLogout(){

		$this->user = unserialize(Session::get('SESSION_KEY_CHIRP_USER'));

		// セッションタイムアウト時はログ出力しない（userが取得できない為）
		if ($this->user) {
			// 操作履歴ログ出力
			DataManager::registerOperationLog(
					$this->user->getLoginId(),
					'-',
					'ログアウト',
					'');
		}
		// セッションからユーザーオブジェクトを削除
		Session::forget('SESSION_KEY_CHIRP_USER');
		Session::forget('SESSION_KEY_REPORT_DATA');

		return Redirect::to('/');
	}

}
