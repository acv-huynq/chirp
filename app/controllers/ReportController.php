<?php

/**
 * レポート画面
 */
class ReportController extends BaseController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * レポート画面表示
	 */
	function getIndex() {

		$mode = Session::get('_mode');
		$report_no = Session::get('_report_no');
		$report_class = Session::get('_report_class');
		$modified = Session::get('_modified');

		$report_info;
		$attach_file_list;
		$gender_list;
		$phoenix_class_list;
		$related_report_list;
		$individuals_info;

		// 関連レポート表示またはリダイレクトの場合
		if($mode != 'relation' && Session::has('SESSION_KEY_REPORT_DATA')){

			// セッションから情報取得
			$data = Session::get('SESSION_KEY_REPORT_DATA');

			$report_info = $data['report_info'];
			$attach_file_list = $data['attach_file_list'];
			$gender_list = $data['gender_list'];
			$phoenix_class_list = $data['phoenix_class_list'];
			$related_report_list = $data['related_report_list'];
			$individuals_info = $data['individuals_info'];

		// 初期表示の場合
		}else{

			// レポート情報取得
			if($report_no){

				$report_info = $this->getReportInfo($report_no);

			}else{
				$report_info = $this->getEmptyReportInfo($report_class);
			}

			// 添付ファイル一覧取得
			$attach_file_list = $this->getAttacheFileList($report_no);

			// 性別リスト取得
			$gender_list = SystemCodeManager::getGender();

			// Phoenix class取得
			$phoenix_class_list = SystemCodeManager::getPhoenixClass($report_class);

			// 関連レポート取得
			$related_report_list = $this->getRelatedReportList($report_info);

			// レポート個別情報取得
			$individuals_info = $this->getIndividualsInfo($report_no, $report_class);

			$data = [
						'report_info' 			=> 	$report_info,
						'attach_file_list' 		=> 	$attach_file_list,
						'gender_list'			=>	$gender_list,
						'phoenix_class_list'	=>	$phoenix_class_list,
						'related_report_list'	=>	$related_report_list,
						'individuals_info'		=>	$individuals_info
			];

			if($mode != 'relation'){
				Session::put('SESSION_KEY_REPORT_DATA', $data);
			}else{
				Session::put('SESSION_KEY_RELATION_REPORT_DATA', $data);
			}
		}

		// 権限情報取得
		$role_manage_info = DataManager::getRoleManageinfo($mode, $this->user->userInfo->user_role, $report_info->report_status);

		// レポート個別アラート設定取得
		$report_alert = DataManager::isReportAlert($this->user->userInfo->login_id, $report_no);

		$individuals_data = [
			'report_info' 		=> $report_info,
			'role_manage_info' 	=> $role_manage_info
		];
		foreach ($individuals_info as $key => $value){
			$individuals_data[$key] = $value;
		}

		return View::make('report')
			// ヘッダーエリア
			->nest('parts_common_header', 'parts.common.header', ['header_title' => '- ' . Config::get('const.REPORT_CLASS_NAME')[$report_class], 'login_button_hidden' => ''])
			// エラーメッセージ表示エリア
			->nest('parts_common_error',  'parts.common.error', ['error_message_list' => Session::get('error_message_list')])
			// レポート個別アラートボタンエリア
			->nest('parts_report_alert_button', 'parts.report.report_alert_button', ['report_alert' => $report_alert, 'role_manage_info' => $role_manage_info])
			// 設定エリア
			->nest('parts_report_config_area', 'parts.report.config_area', ['report_info' => $report_info, 'role_manage_info' => $role_manage_info])
			// レポートステータスエリア
			->nest('parts_report_status_area', 'parts.report.report_status_area', ['report_info' => $report_info])
			// レポート個別エリア
			->nest('parts_report_individuals_area',
					Config::get('const.reportViews')[$report_class],
					$individuals_data)
			// フライト個別エリア
			->nest('parts_flight_info_area', str_replace('report_', 'flight_info_', Config::get('const.reportViews')[$report_class]), $individuals_data)
			// レポート定義個別エリア
			->nest('parts_report_definition_area', str_replace('report_', 'report_definition_', Config::get('const.reportViews')[$report_class]), $individuals_data)
			// 添付ファイルエリア
			->nest('parts_report_attached_file_area', 'parts.report.attached_file_area', [ 'attach_file_list' => $attach_file_list, 'role_manage_info' => $role_manage_info])
			// 照会エリア
			->nest('parts_report_inquiry_area', 'parts.report.inquiry_area', ['report_info' => $report_info, '_mode' => $mode, 'role_manage_info' => $role_manage_info])
			// 関連レポートエリア
			->nest('parts_report_related_report_area', 'parts.report.related_report_area', ['_mode' => $mode, 'report_info' => $report_info, 'role_manage_info' => $role_manage_info, 'related_report_list' => $related_report_list])
			// 備考欄エリア
			->nest('parts_remarks_area', 'parts.report.remarks_area', ['_mode' => $mode, 'report_info' => $report_info, 'role_manage_info' => $role_manage_info])
			// 客様情報エリア
			->nest('parts_report_pax_info_area', 'parts.report.pax_info_area', ['report_info' => $report_info, 'gender_list' => $gender_list, 'role_manage_info' => $role_manage_info])
			// 予約情報エリア
			->nest('parts_resavation_info_area', 'parts.report.resavation_info_area', ['report_info' => $report_info, 'gender_list' => $gender_list, 'role_manage_info' => $role_manage_info])
			// Phoenixエリア
			->nest('parts_report_phoenix_area', 'parts.report.phoenix_area', ['report_info' => $report_info, 'phoenix_class_list' => $phoenix_class_list, 'role_manage_info' => $role_manage_info])
			// メール送信先選択エリア
			->nest('parts_report_send_mail_area', 'parts.report.send_mail_area', ['role_manage_info' => $role_manage_info, 'error_message_list' => Session::get('error_message_list')])
			// ボタンエリア
			->nest('parts_report_button_area', 'parts.report.button_area', ['role_manage_info' => $role_manage_info])
			->with('header_title', '- ' . $this->user->userInfo->report_name)
			->with('_mode', $mode)
			->with('error_message_list',Session::get('error_message_list'))
			->with('role_manage_info', $role_manage_info)
			->with('report_info', $report_info);
	}

	/**
	 * 添付ファイル一覧取得
	 * @param unknown $report_no
	 */
	function getAttacheFileList($report_no){
		return DB::select(Config::get('sql.SELECT_REPORT_ATTACHE_FILE_LIST'), [$report_no]);
	}


	/**
	 * 添付ファイルダウンロード
	 */
	function postDownload(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$file_seq = Input::get('_file_seq');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'添付ファイルダウンロード:' . $file_seq,
				$report_no);

		$result = DB::selectOne(Config::get('sql.SELECT_REPORT_ATTACHE_FILE'), [$report_no, $file_seq]);

		if(!$result) {
			$this->error_message_list[] = '該当ファイルは削除されています。';
		}


// 		$ua = $_SERVER['HTTP_USER_AGENT'];
// 		if (strstr($ua, 'MSIE') && !strstr($ua, 'Opera')) {
// 			$file_name = str_replace( ' ', '_', $file_name );
// log::info($file_name);
// 		} else {
// 			$file_name = '"' . $file_name . '"';
// 		}

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		}

		$file_name = $result->file_name;
		// レスポンスヘッダに「Transfer-Encoding=chunked」が設定されるので、「Content-Length」は設定しない
		return Response::make($result->file, 200)
		->header('Content-Type', 'application/octet-stream')
// 		->header('Content-disposition', 'attachment; filename=' . urlencode($result->file_name));
//  		->header('Content-disposition', 'attachment; filename=' . rawurlencode($result->file_name));

		->header('Content-disposition', 'attachment; filename*=UTF-8\'\'' . rawurlencode($result->file_name));
// 		->header('Content-disposition', 'attachment; filename=' . $file_name);

	}


	/**
	 * カテゴリ選択
	 */
	function postChange(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_type = Input::get('report_type');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');

		// カテゴリ取得
		$category_list = SystemCodeManager::getCategory($report_class, $report_type);

		// 権限情報取得
		$role_manage_info = DataManager::getRoleManageinfo($mode, $this->user->userInfo->user_role, $report_status);

		if($mode != 'relation'){
			$report_info = $this->getSessionReportInfo();
		}else{
			$report_info = $this->getSessionRelationReportInfo();
		}

		if($mode != 'relation'){
			$select_categoly_info = $this->getSessionIndividualsInfo()['select_categoly_info'];
		}else{
			$select_categoly_info = $this->getSessionRelationIndividualsInfo()['select_categoly_info'];
		}

		return View::make('parts.report.category')
			->with('category_option', $report_type)
			->with('category_list', $category_list)
			->with('report_info', $report_info)
			->with('select_categoly_info', $select_categoly_info)
			->with('role_manage_info', $role_manage_info);
	}

	/**
	 * 変更ボタン押下時の処理
	 */
	function postEdit(){

		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$modified = Input::get('_modified');
		$report_status = Input::get('_report_status');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'変更',
				$report_no);

		return Redirect::to('/report')
		->with('_mode', Config::get('const.EDIT_MODE_OF_STATUS')[$report_status])
		->with('_report_no', $report_no)
		->with('_report_class', $report_class);
	}

	/**
	 * キャンセルボタン押下時の処理
	 */
	function postCancel(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'キャンセル',
				$report_no);

		if($mode == 'relation'){

			$data = Session::pull('SESSION_KEY_PREV_REPORT_PARAM');

			return Redirect::to('/report')
				->with('_mode', $data['mode'])
				->with('_report_no', $data['report_no'])
				->with('_report_class', $data['report_class']);
		}
		return Redirect::to('/top');
	}

	/**
	 * 保存ボタン押下時の処理
	 */
	function postSave(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'保存',
				$report_no);

		DB::transaction(function() use ($mode,$report_no,$report_class,$report_status,$modified)
		{
			if($report_no){

				$status = $report_status;

				// レポート更新
				if(! $this->updateReport($status, false)){
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
				}

			}else{
				// レポート登録
				$this->insertReport(Config::get('const.REPORT_STATUS.CREATED'));
			}
		});

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} elseif($report_status == Config::get('const.REPORT_STATUS.CLOSE')) {

			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
		}


		return Redirect::to('/top');
	}

	/**
	 * 提出ボタン押下時の処理
	 */
	function postSubmit(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'提出',
				$report_no);

		DB::transaction(function() use ($mode,&$report_no,$report_class,&$report_status,$modified)
		{
			if($report_no){

				switch($report_status) {
					case Config::get('const.REPORT_STATUS.CREATED'):
						$report_status = Config::get('const.REPORT_STATUS.SUBMITTED');
						break;
					case Config::get('const.REPORT_STATUS.PASSBACK_SUBMITTED'):
						$report_status = Config::get('const.REPORT_STATUS.RESUBMIT');
						break;
				}

				// レポート更新
				if( ! $this->updateReport($report_status,false)){

					// 排他エラー
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
				}else{



					// エラーがない場合
					if( ! $this->hasError()){


						// メール送信
						$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.Submit'));
					}
				}


			}else{
				// レポート登録
				$report_status = Config::get('const.REPORT_STATUS.SUBMITTED');
				$new_report_no = $this->insertReport($report_status);

				// エラーがない場合
				if( ! $this->hasError()){


					// メール送信
					$this->sendMail($new_report_no, $report_class, Config::get('const.MAIL_KBN.Submit'));
				}
				$report_no = $new_report_no;
			}
		});


		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} else {

			if($report_status == Config::get('const.REPORT_STATUS.SUBMITTED')) {
				$alert_timing = NULL;
				$mail_kbn = Config::get('const.MAIL_KBN.AlertCreated');
			} else {
				$alert_timing = Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED');
				$mail_kbn = Config::get('const.MAIL_KBN.AlertUpdated');
			}
			$user_list = $this->getAlertUserList($report_no, $alert_timing);
			$this->alertMail($report_no, $user_list, $mail_kbn);
		}
		return Redirect::to('/top');
	}

	/**
	 * 関連レポート選択時の処理
	 */
	function postRelatedReport(){

		// 呼び出し元レポート情報をセッションに格納
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'関連レポート選択',
				$report_no);

		$data =[
				'mode' 			=> 	$mode,
				'report_no' 	=> 	$report_no,
				'report_class'	=>	$report_class,
		];
		Session::put('SESSION_KEY_PREV_REPORT_PARAM', $data);

		// 関連レポート情報取得キー
		$related_report_no = Input::get('related_report_no');
		$related_report_class = Input::get('related_report_class');

		$checkAccessControlResult = DataManager::checkAccessControl($related_report_no);
		// 参照NGの場合
		if( ! $checkAccessControlResult->result_code ){

			$this->error_message_list[] = $checkAccessControlResult->error_message;

			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		}

		return Redirect::to('/report')
			->with('_mode', 'relation')
			->with('_report_no',$related_report_no)
			->with('_report_class',$related_report_class);
	}

	/**
	 * 確認ボタン押下時の処理
	 */
	function postConfirm(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'確認',
				$report_no);

		DB::transaction(function() use ($mode,$report_no,$report_class,$report_status,$modified)
		{
			if($report_no){

				switch($report_status) {
					case Config::get('const.REPORT_STATUS.SUBMITTED'):
					case Config::get('const.REPORT_STATUS.RESUBMIT'):
						$report_status = Config::get('const.REPORT_STATUS.CONFIRMED');
						break;
					case Config::get('const.REPORT_STATUS.PASSBACK_CONFIRMED'):
						$report_status = Config::get('const.REPORT_STATUS.RECONFIRM');
						break;
				}

				// レポート更新
				if(! $this->updateReport($report_status,false)){

					// 排他エラー
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
				}else{

					// エラーがない場合
					if( ! $this->hasError()){


						// メール送信
						$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.Confirm'));

					}

				}
			}
		});

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} else {

			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
		}
		return Redirect::to('/top');
	}

	/**
	 * 承認ボタン押下時の処理
	 */
	function postClose(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'承認',
				$report_no);

		DB::transaction(function() use ($mode,$report_no,$report_class,$report_status,$modified)
		{
			if($report_no){
				// レポート更新
				if( ! $this->updateReport(Config::get('const.REPORT_STATUS.CLOSE'),false)){

					// 排他エラー
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
				}else{

					// エラーがない場合
					if( ! $this->hasError()){


						// メール送信
						$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.Close'));

					}
				}
			}
		});

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} else {

			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
		}
		return Redirect::to('/top');
	}

	/**
	 * 照会入力ボタン押下時の処理
	 */
	function postInquiry(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'照会入力',
				$report_no);

		return Redirect::to('/report')
		->with('_mode', 'inquiry')
		->with('_report_no', $report_no)
		->with('_report_class', $report_class);
	}

	/**
	 * 照会実施ボタン押下時の処理
	 */
	function postInquirySave(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'照会実施',
				$report_no);

		DB::transaction(function() use ($mode,$report_no,$report_class,$report_status,$modified)
		{

			$param_names = [
					'PEACOCK'	=> ['penguin_inquiry_status','peregrine_inquiry_status','penguin_inquiry_timestamp','peregrine_inquiry_timestamp'],
					'PENGUIN'	=> ['peregrine_inquiry_status','peacock_inquiry_status','peregrine_inquiry_timestamp','peacock_inquiry_timestamp'],
					'PEREGRINE' => ['penguin_inquiry_status','peacock_inquiry_status','penguin_inquiry_timestamp','peacock_inquiry_timestamp']
			];
			$parame = $param_names[$this->user->userInfo->report_name];

			$inquiry_status1 = (Input::get($parame[0]) === 'on' ? Config::get('const.INQUIRY_STATUS.INQUIRY') : null);
			$inquiry_status2 = (Input::get($parame[1]) === 'on' ? Config::get('const.INQUIRY_STATUS.INQUIRY') : null);


			if(	CommonCheckLogic::isEmpty($inquiry_status1) &&
				CommonCheckLogic::isEmpty($inquiry_status2)){
				$this->error_message_list[] = '照会先が選択されていません';
			}else{

				// セッションから現在のレポート情報を取得
				$report_info = (array)$this->getSessionReportInfo();
				$old_inquiry_status1 = $report_info[$parame[0]];
				$old_inquiry_status2 = $report_info[$parame[1]];
				$old_inquiry_timestamp1 = $report_info[$parame[2]];
				$old_inquiry_timestamp2 = $report_info[$parame[3]];

				$timestamp = DateUtil::getCurrentTimestamp();
				$inquiry_timestamp1 = $timestamp;
				$inquiry_timestamp2 = $timestamp;

				// チェックされていない場合は現在の値で更新
				if(CommonCheckLogic::isEmpty($inquiry_status1)){

					$inquiry_status1 = $old_inquiry_status1;
					$inquiry_timestamp1 = $old_inquiry_timestamp1;
				}

				// チェックされていない場合は現在の値で更新
				if(CommonCheckLogic::isEmpty($inquiry_status2)){

					$inquiry_status2 = $old_inquiry_status2;
					$inquiry_timestamp2 = $old_inquiry_timestamp2;
				}

				$data = [
						$inquiry_status1,
						$inquiry_timestamp1,
						$inquiry_status2,
						$inquiry_timestamp2,
						$this->user->userInfo->login_id,
						$timestamp,
						$report_no,
						$modified
				];

				if($report_no){
					// レポート更新
					if( ! DB::update(Config::get('sql.EXECUTE_INQUIRY.' . $this->user->userInfo->report_name),$data)){
						$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
					}else{

						// 添付ファイル登録
						DataManager::saveAttachFile($report_no, $timestamp);
						// メール送信
						$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.InquirySave'));

					}
				}
			}
		});

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} else {

			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
		}

		return Redirect::to('/top');
	}

	/**
	 * 回答ボタン押下時の処理
	 */
	function postAnswerToInquiry(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'回答',
				$report_no);

		DB::transaction(function() use ($mode,$report_no,$report_class,$report_status,$modified)
		{
			if($report_no){

				$timestamp = DateUtil::getCurrentTimestamp();
				$data = [
					Config::get('const.INQUIRY_STATUS')['ANSWER'],
					$timestamp,
					$this->user->userInfo->login_id,
					$timestamp,
					$report_no,
					$modified
				];

				// レポート更新
				if( ! DB::update(Config::get('sql.EXECUTE_ANSWER_TO_INQUIRY')[$this->user->userInfo->report_name],$data)){

					// 排他エラー
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');

				}else{

					// 添付ファイル登録
					DataManager::saveAttachFile($report_no, $timestamp);

					// エラーがない場合
					if( ! $this->hasError()){


						// メール送信
						$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.AnswerToInquiry'));


					}
				}
			}

		});

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} else {

			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
		}
		return Redirect::to('/top');
	}

	/**
	 * 回答閲覧済ボタン押下（Ajax）
	 */
	function postAnswerRead() {

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'回答閲覧済',
				$report_no);

		$modified = DB::transaction(function() use ($mode,$report_no,$report_class,$modified)
		{
			if($report_no){

				$param_names = [
						'PEACOCK'	=> ['penguin_inquiry_status','peregrine_inquiry_status','penguin_inquiry_timestamp','peregrine_inquiry_timestamp'],
						'PENGUIN'	=> ['peregrine_inquiry_status','peacock_inquiry_status','peregrine_inquiry_timestamp','peacock_inquiry_timestamp'],
						'PEREGRINE' => ['penguin_inquiry_status','peacock_inquiry_status','penguin_inquiry_timestamp','peacock_inquiry_timestamp']
				];
				$parame = $param_names[$this->user->userInfo->report_name];

				// セッションから現在のレポート情報を取得
				$report_info = (array)$this->getSessionReportInfo();
				$old_inquiry_status1 = $report_info[$parame[0]];
				$old_inquiry_status2 = $report_info[$parame[1]];
				$old_inquiry_timestamp1 = $report_info[$parame[2]];
				$old_inquiry_timestamp2 = $report_info[$parame[3]];

				$timestamp = DateUtil::getCurrentTimestamp();

				$inquiry_timestamp1 = $old_inquiry_timestamp1;
				$inquiry_timestamp2 = $old_inquiry_timestamp2;

				$inquiry_status1 = $old_inquiry_status1;
				$inquiry_status2 = $old_inquiry_status2;

				// 回答済みのもののみ回答閲覧済に変更する
				if($inquiry_status1 == Config::get('const.INQUIRY_STATUS')['ANSWER']) {
					$inquiry_status1 = Config::get('const.INQUIRY_STATUS')['ANSWER_READ'];
					$inquiry_timestamp1 = $timestamp;
				}

				if($inquiry_status2 == Config::get('const.INQUIRY_STATUS')['ANSWER']) {
					$inquiry_status2 = Config::get('const.INQUIRY_STATUS')['ANSWER_READ'];
					$inquiry_timestamp2 = $timestamp;
				}
				$data = [
					$inquiry_status1,
					$inquiry_timestamp1,
					$inquiry_status2,
					$inquiry_timestamp2,
					$this->user->userInfo->login_id,
					$timestamp,
					$report_no,
					$modified
				];

				// レポート更新
				if( ! DB::update(Config::get('sql.EXECUTE_INQUIRY')[$this->user->userInfo->report_name],$data)){

					// 排他エラー
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');

				}else{

					// 添付ファイル登録： 2016/4/5 不要ではあるが意図が不明である為コメント
					//DataManager::saveAttachFile($report_no, $timestamp);

					// エラーがない場合
					if( ! $this->hasError()){

						// セッションから情報取得
						$data = Session::get('SESSION_KEY_REPORT_DATA');

						$data['report_info']->update_timestamp = $timestamp;
						Session::put('SESSION_KEY_REPORT_DATA', $data);

						return $timestamp;

						// メール送信
						//$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.AnswerToInquiry'));

					}
				}
			}

		});

		// エラーがない場合
		if(!$this->hasError()){
			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
			return str_replace('-', '/', $modified);
		}
		// 2016/04/05 エラー時返却値追加
		return "0";
	}

	protected function executeAnswerToInquery(){
		throw new Exception('未実装');
	}

	/**
	 * 差戻ボタン押下時の処理
	 */
	function postPassback(){

		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'差戻し',
				$report_no);

		DB::transaction(function() use ($mode,$report_no,$report_class,$report_status,$modified)
		{
			if($report_no){
				// レポート更新
				switch($report_status) {
					case Config::get('const.REPORT_STATUS.SUBMITTED'):
					case Config::get('const.REPORT_STATUS.RESUBMIT'):
					case Config::get('const.REPORT_STATUS.PASSBACK_CONFIRMED'):
						$report_status = Config::get('const.REPORT_STATUS.PASSBACK_SUBMITTED');
						break;
					case Config::get('const.REPORT_STATUS.CONFIRMED'):
					case Config::get('const.REPORT_STATUS.RECONFIRM'):
						$report_status = Config::get('const.REPORT_STATUS.PASSBACK_CONFIRMED');
						break;
				}
				if( ! $this->updateReport($report_status, true)){

					// 排他エラー
					$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
				}else{

					// エラーがない場合
					if( ! $this->hasError()){


						// メール送信
						$this->sendMail($report_no, $report_class, Config::get('const.MAIL_KBN.Passback'));

					}

				}
			}
		});

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		} else {

			$user_list = $this->getAlertUserList($report_no, Config::get('const.ALERT_MAIL_TIMING.CREATED_AND_UPDATED'));
			$this->alertMail($report_no, $user_list, Config::get('const.MAIL_KBN.AlertUpdated'));
		}
		return Redirect::to('/top');
	}

	/**
	 * 削除ボタン押下時の処理
	 */
	function postDelete(){

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_no = Input::get('_report_no');
		$report_class = Input::get('_report_class');
		$report_status = Input::get('_report_status');
		$modified = Input::get('_modified');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'削除',
				$report_no);

		if($report_no){
			// レポート更新
			if( ! DB::update(
				Config::get('sql.LOGICAL_DELETE_REPORT_BASIC_INFO'),
				[
					'1',
					$this->user->userInfo->login_id,
					DateUtil::getCurrentTimestamp(),
					$report_no,
					$modified
				])){
				// 排他エラー
				$this->error_message_list[] = Config::get('message.EXCLUSIVE_ERROR');
			}
		}

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/report')
			->with('error_message_list', $this->error_message_list)
			->with('_mode',$mode)
			->with('_report_no',$report_no)
			->with('_report_class',$report_class)
			->with('_modified',$modified)
			->withInput(Input::all());
		}
		return Redirect::to('/top');
	}

	/**
	 * コメント追加ボタン押下時の処理（AJAX）
	 */
	function postAddComment(){

		// リクエストパラメータ取得
		$report_no = Input::get('modal_report_no');
		$comment = Input::get('modal_comment');
		$author = Input::get('modal_author');
		$report_class = input::get('_report_class');
		$mode = input::get('_mode');
		$timestamp = date("Y-m-d H:i:s");

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'コメント追加',
				$report_no);

		$data = [
			$report_no,
			$comment,
			$author,
			$this->user->userInfo->report_name,
			$timestamp,
			$report_no
		];

		DB::insert(Config::get('sql.INSERT_REPORT_COMMENT'),$data);

		// コメント一覧取得
		$comment_list = DataManager::getCommentList($report_no);

		// TODO:取得失敗時の処理

		return View::make('parts.report.comment')
		->with('comment_list', $comment_list);
	}

	/**
	 * コメント取得（AJAX）
	 */
	function postComment(){

		// リクエストパラメータ取得
		$report_no = Input::get('report_no');

		// コメント一覧取得
		$comment_list = DataManager::getCommentList($report_no);

		// TODO:取得失敗時の処理

		return View::make('parts.report.comment')
		->with('comment_list', $comment_list);
	}

	/**
	 * セッションからレポート情報を取得
	 * @return unknown
	 */
	protected function getSessionReportInfo(){
		$data = Session::get('SESSION_KEY_REPORT_DATA');
		return $data['report_info'];
	}

	/**
	 * セッションからレポート固有情報を取得
	 * @return unknown
	 */
	protected function getSessionIndividualsInfo(){
		$data = Session::get('SESSION_KEY_REPORT_DATA');
		return $data['individuals_info'];
	}


	/**
	 * セッションから関連レポート情報を取得
	 * @return unknown
	 */
	protected function getSessionRelationReportInfo(){
		$data = Session::get('SESSION_KEY_RELATION_REPORT_DATA');
		return $data['report_info'];
	}

	/**
	 * セッションから関連レポート固有情報を取得
	 * @return unknown
	 */
	protected function getSessionRelationIndividualsInfo(){
		$data = Session::get('SESSION_KEY_RELATION_REPORT_DATA');
		return $data['individuals_info'];
	}


	/**
	 * レポート情報取得
	 * @param $report_no
	 * @return レポート情報
	 */
	protected function getReportInfo($report_no){
		throw new Exception('サブクラスで実装すること！');
	}

	/**
	 * 空のレポート情報取得
	 * @return レポート情報
	 * @throws Exception
	 */
	protected function getEmptyReportInfo($report_class){
		throw new Exception('サブクラスで実装すること！');
	}


	/**
	 * 関連レポート取得
	 * @param unknown $reportInfo
	 */
	protected function getRelatedReportList($report_info){

		$data;
		switch ($report_info->report_class){
			case Config::get('const.REPORT_CLASS.PENGUIN'):
				$data = [
						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->departure_date_2,
						$report_info->flight_number_2,
						$report_info->departure_date_2,
						$report_info->flight_number_2,
						$report_info->report_no,
						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->departure_date_2,
						$report_info->flight_number_2,
						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->departure_date_2,
						$report_info->flight_number_2
				];
				break;
			case Config::get('const.REPORT_CLASS.PEREGRINE_Incident'):
			case Config::get('const.REPORT_CLASS.PEREGRINE_Irregularity'):
			case Config::get('const.REPORT_CLASS.PEACOCK'):
				$data = [

						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->report_no,
						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->departure_date,
						$report_info->flight_number,
						$report_info->departure_date,
						$report_info->flight_number
				];
				break;
			default:
				return [];
		}
		return DB::select(
				Config::get('sql.SELECT_RELATED_REPORT_LIST')[Config::get('const.REPORT_CLASS_BASIC_NAME')[$report_info->report_class]],
				$data);
	}

	/**
	 * レポート個別情報取得
	 * @param string $report_no レポート番号
	 * @param int $report_class レポート種別
	 * @throws Exception
	 */
	protected function getIndividualsInfo($report_no, $report_class){
		throw new Exception('サブクラスで実装すること！');
	}

	/**
	 * レポート登録
	 * @param int $status ステータス
	 */
	protected function insertReport($status){
		throw new Exception('サブクラスで実装すること！');
	}

	/**
	 * レポート更新
	 * @param int $status ステータス
	 * @param boolean 差戻しフラグ(true:差戻しの場合)
	 */
	protected function updateReport($status, $is_passback){
		throw new Exception('サブクラスで実装すること！');
	}

	/**
	 * メール送信処理
	 */
	function sendMail($report_no, $report_class, $report_kbn){
		$send_checkList =
		[
			0 => Input::get('send_mail_creator') === 'on' ? true : false,
			1 => Input::get('send_mail_administrator_group') === 'on' ? true : false,
			2 => Input::get('send_mail_approver_group') === 'on' ? true : false,
			3 => Input::get('send_mail_inquiry_from_administrator_group') === 'on' ? true : false,
			4 => Input::get('send_mail_inquiry_to_administrator_group') === 'on' ? true : false,
		];
		$inquiry_checkList =
		[
			1 => Input::get('penguin_inquiry_status') === 'on' ? true : false,
			2 => Input::get('peregrine_inquiry_status') === 'on' ? true : false,
			4 => Input::get('peacock_inquiry_status') === 'on' ? true : false,
		];

		$report_title = input::get('report_title');

		if (!$report_title) {
			$report_info = $this->getSessionReportInfo();
			$report_title = $report_info->report_title;
		}

		foreach($send_checkList as $role => $check){
			if($check === false){
				continue;
			}
			if($role == 3){
				// 照会元→管理者宛て
				$role = 1;
			}
			if($role == 4){
				// 照会先
				foreach($inquiry_checkList as $toReport_class => $check){
					// 照会先→管理者宛て
					$role = 1;
					if($check === false){
						continue;
					}
					MailManager::send(
						$report_no,
						$toReport_class,
						$role,
						$report_kbn,
						[
						'@repono@'=>$report_no,
						'@title@'=>$report_title
					]
					);
				}
			}else{
				// 照会先以外
				MailManager::send(
					$report_no,
					$report_class,
					$role,
					$report_kbn,
					[
					'@repono@'=>$report_no,
					'@title@'=>$report_title
					]
				);
			}
		}

	}

	/**
	 * 送信先チェック
	 */
	function checkSendMail($is_passback){

		$mode = Input::get('_mode');
		$send_mail_creator = Input::get('send_mail_creator') === 'on' ? true : false;
		$send_mail_administrator_group = Input::get('send_mail_administrator_group') === 'on' ? true : false;
		$send_mail_approver_group = Input::get('send_mail_approver_group') === 'on' ? true : false;
		$send_mail_inquiry_from_administrator_group = Input::get('send_mail_inquiry_from_administrator_group') === 'on' ? true : false;
		$send_mail_inquiry_to_administrator_group_hidden = Input::get('send_mail_inquiry_to_administrator_group_hidden') === 'on' ? true : false;

		if ($is_passback) {
			// 差戻し時
			if($mode == 'confirm' && $send_mail_approver_group){
				$this->error_message_list[] = "差戻し時に承認者にメールを送信することは出来ません。";
			}

			if($mode == 'close' && $send_mail_creator){
				$this->error_message_list[] = "差戻し時に起票者にメールを送信することは出来ません。";
			}
		} else if ($mode == 'confirm') {
			// 確認時
			if($mode == 'confirm' && $send_mail_creator){
				$this->error_message_list[] = "確認時に起票者にメールを送信することは出来ません。";
			}
		}

	}

	/**
	 * レポート個別アラート設定（Ajax）
	 */
	function postAlertSetting() {

		// リクエストパラメータ取得
		$mode = Input::get('_mode');
		$report_class = Input::get('_report_class');
		$report_no = Input::get('_report_no');
		$report_alert = Input::get('_report_alert');

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->getLoginId(),
				Config::get('const.REPORT_CLASS_NAME')[$report_class] . ':' . Config::get('const.REPORT_MODE_NAME')[$mode],
				'レポート個別アラート設定' . ($report_alert ? 'Off' : 'On'),
				$report_no);

		// #12 2016/4/4 変数未参照問題対応
		$result = "0";
		$result = DB::transaction(function() use ($report_no, $report_alert)
		{
			if($report_alert){

				$result = DB::table('alert_mail_condition')
					->where('login_id', $this->user->userInfo->login_id)
					->where('report_no', $report_no)
					->delete();
			} else {

				$result = DB::table('alert_mail_condition')
				->insert([
						'login_id' => $this->user->userInfo->login_id,
						'report_no' => $report_no,
						'alert_timing' => Config::get('const.ALERT_MAIL_TIMING')['CREATED_AND_UPDATED'],
				]);

			}
			return $result;
		});

		return "".$result;
	}

	function getAlertUserList($report_no, $alert_timing = NULL) {

		if(is_null($alert_timing)) {
			$alert_timing = Config::get('ALERT_TIMING.CREATED_AND_UPDATED');
		}

		$result = DB::table('alert_mail_condition')
			->distinct()
			->select(['login_id'])
			->where('report_no', $report_no)
			->where('alert_timing', $alert_timing)
			->get();

		$ret = array();
		foreach($result as $row) {
			$ret[] = $row->login_id;
		}

		return $ret;
	}

	function alertMail($report_no, $user_list, $mail_kbn) {

		if(count($user_list)) {
			$report_title = input::get('report_title');

			if (!$report_title) {
				$report_info = $this->getSessionReportInfo();
				$report_title = $report_info->report_title;
			}

			MailManager::alertMail($user_list, $mail_kbn, ['@repono@'=>$report_no,'@title@'=>$report_title]);
		}
	}
}
