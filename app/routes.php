<?php

/*
|--------------------------------------------------------------------------
| アプリケーションルート
|--------------------------------------------------------------------------
|
| このファイルでアプリケーションの全ルートを定義します。
| 方法は簡単です。対応するURIをLaravelに指定してください。
| そしてそのURIに対応する実行コードをクロージャーで指定します。
|
*/

/*
 * レポート画面
 */
Route::controller('/report', getReportController());

/*
 * トップ画面
 */
Route::controller('/top', getTopController());

/*
 * プレビュー画面
 */
Route::controller('/preview', getPreviewController());

/**
 * アラート設定画面
 */
Route::controller('/alert', 'AlertController');

/*
 * ログイン画面
 */
Route::controller('/', 'LoginController');

// /*
//  * ルートの場合はリダイレクト
//  */
// Route::get('/', function()
// {
// 	return Redirect::To('/');
// });

function getTopController(){

	// ユーザー情報取得
	$user = unserialize(Session::get('SESSION_KEY_CHIRP_USER'));

	if($user){
		return Config::get('const.topControllers')[$user->userInfo->report_name];
	}
// 	return 'ErrorController';
	return Config::get('const.topControllers')['PEACOCK'];
}

function getReportController(){
	$report_class = Session::get('_report_class');
	if(!$report_class){
		$report_class = Input::get('_report_class');
	}
	if($report_class){
		return Config::get('const.reportControllers')[Config::get('const.REPORT_CLASS_BASIC_NAME')[$report_class]];

	}
	return 'ErrorController';
}

function getPreviewController() {
	$report_class = Session::get('_report_class');

	if(!$report_class){
		$report_class = Input::get('_report_class');
	}
	if($report_class) {
		return Config::get('const.previewControllers')[Config::get('const.REPORT_CLASS_BASIC_NAME')[$report_class]];
	}
	return 'ErrorController';
}