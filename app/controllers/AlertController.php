<?php

/**
 * アラート設定画面
 */
class AlertController extends BaseController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * アラート設定画面表示
	 */
	function anyIndex() {

		$header_title = '- ' . $this->user->userInfo->report_name;

		$station_list = $this->getStationList();

		$alert_setting = $this->getAlertSetting();

		return View::make('alert')
		// ヘッダーエリア
		->nest('parts_common_header', 'parts.common.header', ['header_title' => $header_title . ' Alert', 'login_button_hidden' => ''])
		// エラーメッセージ表示エリア
		->nest('parts_common_error',  'parts.common.error', ['error_message_list' => Session::get('error_message_list')])
		->with('header_title', $header_title)
		->with('station_list', $station_list)
		->with('alert_setting', $alert_setting);

	}

	/**
	 * キャンセル
	 */
	function postCancel() {

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				'アラート設定画面',
				'キャンセル',
				'');

		return Redirect::to('/top');
	}

	/**
	 * 保存
	 */
	function postSave() {

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				'アラート設定画面',
				'保存',
				'');

		// リクエストパラメータ取得
		$timing = Input::get('timing');
		$station = Input::get('station');
		// ログインID取得
		$login_id = $this->user->userInfo->login_id;

		// エラーチェック
		if(strlen($timing) == 0 && count($station)) {
			$this->error_message_list[] = "通知設定を選択してください\n" . "Select the Alert on";
		} elseif(strlen($timing) > 0 && count($station) == 0) {
			$this->error_message_list[] = "空港名を選択してください\n" . "Check the Station(s)";
		}

		if($this->hasError()) {
			return Redirect::to('/alert')
			->with('error_message_list', $this->error_message_list)
			->withInput(Input::only('timing','station'));
		}

		// トランザクション開始
		DB::transaction(function() use ($login_id, $timing, $station) {

			DB::table('alert_mail_condition')
				->where('login_id', $login_id)
				->where('report_no', '')
				->delete();

			if(strlen($timing) > 0) {
				foreach($station as $val) {
					DB::table('alert_mail_condition')
						->insert([
								'login_id' => $login_id,
								'station' => $val,
								'alert_timing' => $timing
						]);
				}
			}
		});

		return Redirect::to('/top');
	}

	/**
	 * 空港名取得
	 * @return unknown
	 */
	function getStationList() {

		$result = DB::table('mst_system_code')
			->distinct()
			->select(['code2', 'value2'])
			->where('code1', 'Station')
			->whereIn('report_class', ['2', '3'])
			->orderBy('disp_order')
			->get();

		return $result;
	}

	/**
	 * アラート設定状態取得
	 */
	function getAlertSetting() {

		$result = DB::table('alert_mail_condition')
			->select(['station', 'alert_timing'])
			->where('login_id', $this->user->userInfo->login_id)
			->where('report_no', '')
			->get();

		$station = [];
		foreach($result as $val) {
			$station[] = $val->station;
		}

		$alert_setting = [];
		if(count($result)) {
			$alert_setting = [
					'timing' => $result[0]->alert_timing,
					'station' => $station
			];
		} else {
			$alert_setting = [
					'timing' => Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'),
					'station' => []
			];
		}

		return $alert_setting;
	}
}