<?php

/**
 * レポート画面（PENGIN）
 */
class ReportControllerPENGUIN extends ReportController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * レポート情報取得
	 * @see ReportController::getReportInfo()
	 */
	protected function getReportInfo($report_no){

		return DB::selectOne(Config::get('sql.SELECT_REPORT_INFO_PENGUIN'),['1','1', 'Sub Category' ,$report_no, '1']);
	}

	/**
	 * 空のレポート情報取得
	 * @see ReportController::getEmptyReportInfo()
	 */
	protected function getEmptyReportInfo($report_class){

		$emptyData = new stdClass();
		$emptyData->report_no = '';
		$emptyData->report_seq = '';
		$emptyData->report_class = $report_class;
		$emptyData->own_department_only_flag = '';
		$emptyData->has_additional_pax_info = 0;
		$emptyData->has_additional_reservation_info = 0;
		$emptyData->report_status_name = '';
		$emptyData->report_status = Config::get('const.REPORT_STATUS.CREATED');
		$emptyData->day_of_week = '';
		$emptyData->reported_by = '';
		$emptyData->report_title = '';
		$emptyData->contents = '';
		$emptyData->confirmor_id = '';
		$emptyData->approver_id = '';
		$emptyData->peacock_inquiry_status = '';
		$emptyData->peacock_inquiry_timestamp = '';
		$emptyData->penguin_inquiry_status = '';
		$emptyData->penguin_inquiry_timestamp = '';
		$emptyData->peregrine_inquiry_status = '';
		$emptyData->peregrine_inquiry_timestamp = '';
		$emptyData->old_report_no = '';
		$emptyData->related_report_no = '';
		$emptyData->related_report_class = '';
		$emptyData->related_report_no_2 = '';
		$emptyData->related_report_class_2 = '';
		$emptyData->firstname = '';
		$emptyData->lastname = '';
		$emptyData->title_rcd = '';
		$emptyData->birthday = '';
		$emptyData->phone_number1 = '';
		$emptyData->phone_number2 = '';
		$emptyData->record_locator = '';
		$emptyData->firstname_2 = '';
		$emptyData->lastname_2 = '';
		$emptyData->title_rcd_2 = '';
		$emptyData->birthday_2 = '';
		$emptyData->phone_number1_2 = '';
		$emptyData->phone_number2_2 = '';
		$emptyData->record_locator_2 = '';
		$emptyData->firstname_3 = '';
		$emptyData->lastname_3 = '';
		$emptyData->title_rcd_3 = '';
		$emptyData->birthday_3 = '';
		$emptyData->phone_number1_3 = '';
		$emptyData->phone_number2_3 = '';
		$emptyData->record_locator_3 = '';
		$emptyData->phoenix_class = '';
		$emptyData->phoenix_memo = '';
		$emptyData->free_comment = '';
		$emptyData->delete_flag = '';
		$emptyData->create_user_id = '';
		$emptyData->create_timestamp = '';
		$emptyData->update_user_id = '';
		$emptyData->update_timestamp = '';
		$emptyData->station = $this->user->getStation();
		$emptyData->line = '';
		$emptyData->first_contatct_date = '';
		$emptyData->first_contact_time = '';
		$emptyData->last_contact_date = '';
		$emptyData->last_contact_time = '';
		$emptyData->category = '';
		$emptyData->sub_category = '';
		$emptyData->correspondence = '';
		$emptyData->departure_date = '';
		$emptyData->flight_number = 'MM';
		$emptyData->departure_date_2 = '';
		$emptyData->flight_number_2 = '';
		$emptyData->day_of_week = '';
		$emptyData->sub_category_other = '';
		return $emptyData;

	}

	/**
	 * レポート個別情報取得
	 * @see ReportController::getIndividualsInfo()
	 */
	protected function getIndividualsInfo($report_no, $report_class){

		// Stationリスト取得
		$station_list = SystemCodeManager::getStation($report_class);

		// Lineリスト取得
		$line_list = SystemCodeManager::getLine($report_class);

		// カテゴリリスト取得
		$category_list = SystemCodeManager::getCategory($report_class);

		// サブカテゴリリスト取得
		$sub_categoly_list = SystemCodeManager::getSubCategory($report_class);

		return [
				'station_list' 		=> 	$station_list,
				'line_list'			=> 	$line_list,
				'category_list'		=> 	$category_list,
				'sub_category_list'	=>	$sub_categoly_list
		];
	}

	/**
	 * レポート登録
	 * @see ReportController::insertReport()
	 */
	protected function insertReport($status){

		$_mode = Input::get('_mode');

		$timestamp = DateUtil::getCurrentTimestamp();

		$report_class = Input::get('_report_class');
		$own_department_only_flag = (Input::get('own_department_only_flag') === 'on' ? '1' : '0');
		$report_status = $status;
		$day_of_week = null;
		$reported_by = Input::get('reported_by');;
		$report_title = Input::get('report_title');
		$contents = Input::get('contents');
		$confirmor_id = null;
		$approver_id = null;
		$peacock_inquiry_status = (Input::get('peacock_inquiry_status') === 'on' ? '1' : '0');
		$peacock_inquiry_timestamp = (Input::get('peacock_inquiry_status') === 'on' ? $timestamp : null);
		$penguin_inquiry_status = (Input::get('penguin_inquiry_status') === 'on' ? '1' : '0');
		$penguin_inquiry_timestamp = (Input::get('penguin_inquiry_status') === 'on' ? $timestamp :null);
		$peregrine_inquiry_status = (Input::get('peregrine_inquiry_status') === 'on' ? '1' : '0');
		$peregrine_inquiry_timestamp = (Input::get('peregrine_inquiry_status') === 'on' ? $timestamp : null);
		$old_report_no = Input::get('old_report_no');
		$related_report_no = Input::get('related_report_no');
		$related_report_no_2 = Input::get('related_report_no_2');
		$firstname = Input::get('firstname');
		$lastname = Input::get('lastname');
		$title_rcd = Input::get('title_rcd');
		$birthday = Input::get('birthday');
		$phone_number1 = Input::get('phone_number1');
		$phone_number2 = Input::get('phone_number2');
		$record_locator = Input::get('record_locator');
		$firstname_2 = Input::get('firstname_2');
		$lastname_2 = Input::get('lastname_2');
		$title_rcd_2 = Input::get('title_rcd_2');
		$birthday_2 = Input::get('birthday_2');
		$phone_number1_2 = Input::get('phone_number1_2');
		$phone_number2_2 = Input::get('phone_number2_2');
		$record_locator_2 = Input::get('record_locator_2');
		$firstname_3 = Input::get('firstname_3');
		$lastname_3 = Input::get('lastname_3');
		$title_rcd_3 = Input::get('title_rcd_3');
		$birthday_3 = Input::get('birthday_3');
		$phone_number1_3 = Input::get('phone_number1_3');
		$phone_number2_3 = Input::get('phone_number2_3');
		$record_locator_3 = Input::get('record_locator_3');
		$phoenix_class = Input::get('phoenix_class');
		$phoenix_memo = Input::get('phoenix_memo');
		$free_comment = Input::get('free_comment');
		$delete_flag = '0';
		$create_user_id = $this->user->getLoginId();
		$create_timestamp = $timestamp;
		$update_user_id = $this->user->getLoginId();
		$update_timestamp = $timestamp;

		$station = Input::get('station');
		$line = Input::get('line');
		$first_contatct_date = Input::get('first_contatct_date');
		$first_contact_time = Input::get('first_contact_time');
		$last_contact_date = Input::get('last_contact_date');
		$last_contact_time = Input::get('last_contact_time');
		$category = Input::get('category');
		$sub_category = Input::get('sub_category');
		if(!$sub_category){
			$sub_category = Input::get('sub_category_other');
		}

		$correspondence = Input::get('correspondence');
		$departure_date = Input::get('departure_date');
		$flight_number = Input::get('flight_number');
		$departure_date_2 = Input::get('departure_date_2');
		$flight_number_2 = Input::get('flight_number_2');
		$day_of_week = Input::get('day_of_week');


		// 必須入力チェック
		if(CommonCheckLogic::isEmpty($station)){
			$this->error_message_list[] = 'Station' . Config::get('message.REQUIRED_ERROR');
		}
		if(CommonCheckLogic::isEmpty($reported_by)){
			$this->error_message_list[] = 'Report by' . Config::get('message.REQUIRED_ERROR');
		}
		if(CommonCheckLogic::isEmpty($report_title)){
			$this->error_message_list[] = 'Report Title' . Config::get('message.REQUIRED_ERROR');
		}

		// 日付フォーマットチェック
		if(! CommonCheckLogic::isDate($birthday, true) ){
			$this->error_message_list[] = '#1 Birthday' . Config::get('message.DATE_FORMAT_ERROR');
		}
		if(! CommonCheckLogic::isDate($birthday_2, true) ){
			$this->error_message_list[] = '#2 Birthday' . Config::get('message.DATE_FORMAT_ERROR');
		}
		if(! CommonCheckLogic::isDate($birthday_3, true) ){
			$this->error_message_list[] = '#3 Birthday' . Config::get('message.DATE_FORMAT_ERROR');
		}
		if(! CommonCheckLogic::isDate($first_contatct_date, true) ){
			$this->error_message_list[] = 'First Contact' . Config::get('message.DATE_FORMAT_ERROR');
		}
		if(! CommonCheckLogic::isDate($last_contact_date, true) ){
			$this->error_message_list[] = 'Last Contact' . Config::get('message.DATE_FORMAT_ERROR');
		}
		if(! CommonCheckLogic::isDate($departure_date, true) ){
			$this->error_message_list[] = '#1 Flight Date' . Config::get('message.DATE_FORMAT_ERROR');
		}
		if(! CommonCheckLogic::isDate($departure_date_2, true) ){
			$this->error_message_list[] = '#2 Flight Date' . Config::get('message.DATE_FORMAT_ERROR');
		}

		// MM + 数値チェック
		if(! CommonCheckLogic::checkFlightNumber($flight_number, true) ){
			$this->error_message_list[] = '#1 Flight NoはMM＋4桁の数字で入力してください。';
		}
		if(! CommonCheckLogic::checkFlightNumber($flight_number_2, true) ){
			$this->error_message_list[] = '#2 Flight NoはMM＋4桁の数字で入力してください。';
		}

		// 関連レポート存在チェック
		if( ! CommonCheckLogic::isExsistsReport($related_report_no, true)){
			$this->error_message_list[] = '#1 Related Reportが存在しません。';
		}
		if( ! CommonCheckLogic::isExsistsReport($related_report_no_2, true)){
			$this->error_message_list[] = '#2 Related Reportが存在しません。';
		}


		// エラーがある場合
		if($this->hasError()){
			return null;
		}

		$result = DataManager::getReportNoAndSeq($report_class, $station, $first_contatct_date);
		$report_no = $result[0];
		$report_seq = $result[1];

		$data =[
				$report_no,
				$report_seq,
				$report_class,
				$own_department_only_flag,
				$report_status,
				$day_of_week,
				$reported_by,
				$report_title,
				$contents,
				$confirmor_id,
				$approver_id,
				$peacock_inquiry_status,
				$peacock_inquiry_timestamp,
				$penguin_inquiry_status,
				$penguin_inquiry_timestamp,
				$peregrine_inquiry_status,
				$peregrine_inquiry_timestamp,
				$old_report_no,
				$related_report_no,
				$related_report_no_2,
				$firstname,
				$lastname,
				$title_rcd,
				$birthday,
				$phone_number1,
				$phone_number2,
				$record_locator,
				$firstname_2,
				$lastname_2,
				$title_rcd_2,
				$birthday_2,
				$phone_number1_2,
				$phone_number2_2,
				$record_locator_2,
				$firstname_3,
				$lastname_3,
				$title_rcd_3,
				$birthday_3,
				$phone_number1_3,
				$phone_number2_3,
				$record_locator_3,
				$phoenix_class,
				$phoenix_memo,
				$free_comment,
				$delete_flag,
				$create_user_id,
				$create_timestamp,
				$update_user_id,
				$update_timestamp
		];
		$data = DataManager::replaceEmptyToNull($data);

		// レポート基本情報登録
		while(DataManager::insertWithCheckDuplicate(Config::get('sql.INSERT_REPORT_BASIC_INFO'), $data)){

			$result = DataManager::getReportNoAndSeq($report_class, $report_type, $first_contatct_date);
			$report_no = $result[0];
			$report_seq = $result[1];
			$data[0] = $report_no;
			$data[1] = $report_seq;
		}

		$data = [
				$report_no,
				$station,
				$line,
				$first_contatct_date,
				$first_contact_time,
				$last_contact_date,
				$last_contact_time,
				$category,
				$sub_category,
				$correspondence,
				$departure_date,
				$flight_number,
				$departure_date_2,
				$flight_number_2,
				$day_of_week
		];
		$data = DataManager::replaceEmptyToNull($data);

		// レポート固有情報登録
		DB::insert(Config::get('sql.INSERT_REPORT_PENGUIN'), $data);

		// 添付ファイル登録
		DataManager::saveAttachFile($report_no, $timestamp);

		// 添付ファイル削除
		DataManager::deleteAttachFile($report_no);

		return $report_no;
	}

	/**
	 * レポート更新
	 * @see ReportController::updateReport()
	 */
	protected function updateReport($status, $is_passback){

		$_mode = Input::get('_mode');
		$modified = Input::get('_modified');

		$timestamp = DateUtil::getCurrentTimestamp();

		$report_no = Input::get('_report_no');
		$own_department_only_flag = (Input::get('own_department_only_flag') === 'on' ? '1' : '0');
		$report_status = $status;
		$day_of_week = null;
		$reported_by = Input::get('reported_by');;
		$report_title = Input::get('report_title');
		$contents = Input::get('contents');
		$confirmor_id = null;
		$approver_id = null;
		$old_report_no = Input::get('old_report_no');
		$related_report_no = Input::get('related_report_no');
		$related_report_no_2 = Input::get('related_report_no_2');
		$firstname = Input::get('firstname');
		$lastname = Input::get('lastname');
		$title_rcd = Input::get('title_rcd');
		$birthday = Input::get('birthday');
		$phone_number1 = Input::get('phone_number1');
		$phone_number2 = Input::get('phone_number2');
		$record_locator = Input::get('record_locator');
		$firstname_2 = Input::get('firstname_2');
		$lastname_2 = Input::get('lastname_2');
		$title_rcd_2 = Input::get('title_rcd_2');
		$birthday_2 = Input::get('birthday_2');
		$phone_number1_2 = Input::get('phone_number1_2');
		$phone_number2_2 = Input::get('phone_number2_2');
		$record_locator_2 = Input::get('record_locator_2');
		$firstname_3 = Input::get('firstname_3');
		$lastname_3 = Input::get('lastname_3');
		$title_rcd_3 = Input::get('title_rcd_3');
		$birthday_3 = Input::get('birthday_3');
		$phone_number1_3 = Input::get('phone_number1_3');
		$phone_number2_3 = Input::get('phone_number2_3');
		$record_locator_3 = Input::get('record_locator_3');
		$phoenix_class = Input::get('phoenix_class');
		$phoenix_memo = Input::get('phoenix_memo');
		$free_comment = Input::get('free_comment');
		$create_user_id = $this->user->userInfo->login_id;
		$create_timestamp = $timestamp;
		$update_user_id = $this->user->userInfo->login_id;
		$update_timestamp = $timestamp;


		$station = Input::get('station');
		$line = Input::get('line');
		$first_contatct_date = Input::get('first_contatct_date');
		$first_contact_time = Input::get('first_contact_time');
		$last_contact_date = Input::get('last_contact_date');
		$last_contact_time = Input::get('last_contact_time');
		$category = Input::get('category');
		$sub_category = Input::get('sub_category');
		if(!$sub_category){
			$sub_category = Input::get('sub_category_other');
		}
		$correspondence = Input::get('correspondence');
		$departure_date = Input::get('departure_date');
		$flight_number = Input::get('flight_number');
		$departure_date_2 = Input::get('departure_date_2');
		$flight_number_2 = Input::get('flight_number_2');
		$day_of_week = Input::get('day_of_week');

		// 変更かつ承認済みの場合
		if($_mode === 'edit' && $status == Config::get('const.REPORT_STATUS.CLOSE')){

			$data =[
					$free_comment,
					$update_user_id,
					$update_timestamp,
					$report_no,
					$modified
			];

			// レポート基本情報更新
			if(DB::update(Config::get('sql.UPDATE_REPORT_BASIC_INFO_ONLY_REMARKS'), $data) == 0){
				return false;
			}

		}else{

			// 必須入力チェック
			if(CommonCheckLogic::isEmpty($station)){
				$this->error_message_list[] = 'Station' . Config::get('message.REQUIRED_ERROR');
			}
			if(CommonCheckLogic::isEmpty($reported_by)){
				$this->error_message_list[] = 'Report by' . Config::get('message.REQUIRED_ERROR');
			}
			if(CommonCheckLogic::isEmpty($report_title)){
				$this->error_message_list[] = 'Report Title' . Config::get('message.REQUIRED_ERROR');
			}

			// 日付フォーマットチェック
			if(! CommonCheckLogic::isDate($birthday, true) ){
				$this->error_message_list[] = '#1 Birthday' . Config::get('message.DATE_FORMAT_ERROR');
			}
			if(! CommonCheckLogic::isDate($birthday_2, true) ){
				$this->error_message_list[] = '#2 Birthday' . Config::get('message.DATE_FORMAT_ERROR');
			}
			if(! CommonCheckLogic::isDate($birthday_3, true) ){
				$this->error_message_list[] = '#3 Birthday' . Config::get('message.DATE_FORMAT_ERROR');
			}

			// MM + 数値チェック
			if(! CommonCheckLogic::checkFlightNumber($flight_number, true) ){
				$this->error_message_list[] = '#1 Flight NoはMM＋4桁の数字で入力してください。';
			}
			if(! CommonCheckLogic::checkFlightNumber($flight_number_2, true) ){
				$this->error_message_list[] = '#2 Flight NoはMM＋4桁の数字で入力してください。';
			}

			// 関連レポート存在チェック
			if( ! CommonCheckLogic::isExsistsReport($related_report_no, true)){
				$this->error_message_list[] = '#1 Related Reportが存在しません。';
			}
			if( ! CommonCheckLogic::isExsistsReport($related_report_no_2, true)){
				$this->error_message_list[] = '#2 Related Reportが存在しません。';
			}

			// メール送信先チェック
			parent::checkSendMail($is_passback);

			// エラーがある場合
			if($this->hasError()){
				return true;
			}

			// セッションから現在のレポート情報を取得
			$old_report_info = $this->getSessionReportInfo();

			// 差戻しの場合
			if($is_passback){

				$confirmor_id = $old_report_info->confirmor_id;
				$approver_id = $old_report_info->approver_id;

			}else{

				// 確認処理の場合
				if($status == Config::get('const.REPORT_STATUS.CONFIRMED')){
					$confirmor_id = $update_user_id;
					$approver_id = $old_report_info->approver_id;
				}
				// 承認処理の場合
				if($status == Config::get('const.REPORT_STATUS.CLOSE')){
					$confirmor_id = $old_report_info->confirmor_id;
					$approver_id = $update_user_id;
				}
			}

			$data =[
					$own_department_only_flag,
					$report_status,
					$day_of_week,
					$reported_by,
					$report_title,
					$contents,
					$confirmor_id,
					$approver_id,
					$old_report_no,
					$related_report_no,
					$related_report_no_2,
					$firstname,
					$lastname,
					$title_rcd,
					$birthday,
					$phone_number1,
					$phone_number2,
					$record_locator,
					$firstname_2,
					$lastname_2,
					$title_rcd_2,
					$birthday_2,
					$phone_number1_2,
					$phone_number2_2,
					$record_locator_2,
					$firstname_3,
					$lastname_3,
					$title_rcd_3,
					$birthday_3,
					$phone_number1_3,
					$phone_number2_3,
					$record_locator_3,
					$phoenix_class,
					$phoenix_memo,
					$free_comment,
					$update_user_id,
					$update_timestamp,
					$report_no,
					$modified
			];

			$data = DataManager::replaceEmptyToNull($data);

			// レポート基本情報更新
			if(DB::update(Config::get('sql.UPDATE_REPORT_BASIC_INFO'), $data) == 0){
				return false;
			}

			$data = [
				$station,
				$line,
				$first_contatct_date,
				$first_contact_time,
				$last_contact_date,
				$last_contact_time,
				$category,
				$sub_category,
				$correspondence,
				$departure_date,
				$flight_number,
				$departure_date_2,
				$flight_number_2,
				$day_of_week,
				$report_no
			];
			$data = DataManager::replaceEmptyToNull($data);

			// レポート固有情報更新
			DB::update(Config::get('sql.UPDATE_REPORT_PENGUIN'), $data);

			// 添付ファイル登録
			DataManager::saveAttachFile($report_no, $timestamp);
			// 添付ファイル削除
			DataManager::deleteAttachFile($report_no);
		}
		return true;
	}
}
