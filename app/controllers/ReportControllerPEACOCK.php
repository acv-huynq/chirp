<?php

/**
 * レポート画面（PEACOCK）
 */
class ReportControllerPEACOCK extends ReportController {

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

		return DB::selectOne(Config::get('sql.SELECT_REPORT_INFO_PEACOCK'),['1','1', $report_no, '1']);
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
		$emptyData->report_type = '';
		$emptyData->flight_report_no = '';
		$emptyData->added_by = '';
		$emptyData->departure_date = '';
		$emptyData->flight_number = 'MM';
		$emptyData->ship_no = '';
		$emptyData->origin_rcd = '';
		$emptyData->destination_rcd = '';
		$emptyData->etd = '';
		$emptyData->atd = '';
		$emptyData->eta = '';
		$emptyData->ata = '';
		$emptyData->crew_cp = '';
		$emptyData->crew_cap = '';
		$emptyData->crew_r1 = '';
		$emptyData->crew_l2 = '';
		$emptyData->crew_r2 = '';
		$emptyData->pax_onboard = '';
		$emptyData->pax_detail = '';
		$emptyData->mr = '';
		$emptyData->staff_comment = '';
		$emptyData->reporting_date = '';
		return $emptyData;
	}

	/**
	 * レポート個別情報取得
	 * @see ReportController::getIndividualsInfo()
	 */
	protected function getIndividualsInfo($report_no, $report_class){

		// Ship Noリスト取得
		$ship_no_list = SystemCodeManager::getShipNo($report_class);

		// Sectorリスト取得
		$sector_list = SystemCodeManager::getSector($report_class);

		// レポートタイプ取得
		$report_type_list = SystemCodeManager::getReportType($report_class);

		// 選択カテゴリ情報取得
		$select_categoly_info = DataManager::getSelectCategoryInfo($report_no);

		return [
				'report_type_list' 		=> 	$report_type_list,
				'ship_no_list'			=> 	$ship_no_list,
				'sector_list'			=> 	$sector_list,
				'select_categoly_info'	=>	$select_categoly_info
		];
	}

	/**
	 * レポート登録
	 * @see ReportController::insertReport()
	 */
	protected function insertReport($status,$new_report_no=''){

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


		$report_type = Input::get('report_type');
		$flight_report_no = Input::get('flight_report_no');
		$added_by = Input::get('added_by');
		$departure_date = Input::get('departure_date');
		$flight_number = Input::get('flight_number');
		$ship_no = Input::get('ship_no');
		$origin_rcd = Input::get('origin_rcd');
		$destination_rcd = Input::get('destination_rcd');
		$etd = Input::get('etd');
		$atd = Input::get('atd');
		$eta = Input::get('eta');
		$ata = Input::get('ata');
		$crew_cp = Input::get('crew_cp');
		$crew_cap = Input::get('crew_cap');
		$crew_r1 = Input::get('crew_r1');
		$crew_l2 = Input::get('crew_l2');
		$crew_r2 = Input::get('crew_r2');
		$pax_onboard = Input::get('pax_onboard');
		$pax_detail = Input::get('pax_detail');
		$mr = Input::get('mr');
		$staff_comment = Input::get('staff_comment');
		$reporting_date = $departure_date;


		// 必須入力チェック
		if(CommonCheckLogic::isEmpty($report_type)){
			$this->error_message_list[] = 'Report Type' . Config::get('message.REQUIRED_ERROR');
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
		if(! CommonCheckLogic::isDate($departure_date, true) ){
			$this->error_message_list[] = 'Flight Date' . Config::get('message.DATE_FORMAT_ERROR');
		}

		// 数字チェック
		if(! CommonCheckLogic::isHalfNumericAndLength($etd, 4, true) ){
			$this->error_message_list[] = 'ETDは4桁の数値で入力してください。';
		}
		if(! CommonCheckLogic::isHalfNumericAndLength($atd, 4, true) ){
			$this->error_message_list[] = 'ATDは4桁の数値で入力してください。';
		}
		if(! CommonCheckLogic::isHalfNumericAndLength($eta, 4, true) ){
			$this->error_message_list[] = 'ETAは4桁の数値で入力してください。';
		}
		if(! CommonCheckLogic::isHalfNumericAndLength($ata, 4, true) ){
			$this->error_message_list[] = 'ATAは4桁の数値で入力してください。';
		}

		// MM + 数値チェック
		if(! CommonCheckLogic::checkFlightNumber($flight_number, true) ){
			$this->error_message_list[] = 'Flight NoはMM＋4桁の数字で入力してください。';
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

		$result = DataManager::getReportNoAndSeq($report_class, $report_type, $departure_date);
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

			$result = DataManager::getReportNoAndSeq($report_class, $report_type, $departure_date);
			$report_no = $result[0];
			$report_seq = $result[1];
			$data[0] = $report_no;
			$data[1] = $report_seq;
		}

		$data = [
				$report_no,
				$report_type,
				$flight_report_no,
				$added_by,
				$departure_date,
				$flight_number,
				$ship_no,
				$origin_rcd,
				$destination_rcd,
				$etd,
				$atd,
				$eta,
				$ata,
				$crew_cp,
				$crew_cap,
				$crew_r1,
				$crew_l2,
				$crew_r2,
				$pax_onboard,
				$pax_detail,
				$mr,
				$staff_comment,
				$reporting_date
		];
		$data = DataManager::replaceEmptyToNull($data);

		// レポート固有情報登録
		DB::insert(Config::get('sql.INSERT_REPORT_PEACOCK'), $data);

		// カテゴリ情報削除・登録
		DataManager::deleteSelectCategoryInfo($report_no);
		DataManager::saveSelectCategoryInfo($report_no, $report_type);

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


		$report_type = Input::get('report_type');
		$flight_report_no = Input::get('flight_report_no');
		$added_by = Input::get('added_by');
		$departure_date = Input::get('departure_date');
		$flight_number = Input::get('flight_number');
		$ship_no = Input::get('ship_no');
		$origin_rcd = Input::get('origin_rcd');
		$destination_rcd = Input::get('destination_rcd');
		$etd = Input::get('etd');
		$atd = Input::get('atd');
		$eta = Input::get('eta');
		$ata = Input::get('ata');
		$crew_cp = Input::get('crew_cp');
		$crew_cap = Input::get('crew_cap');
		$crew_r1 = Input::get('crew_r1');
		$crew_l2 = Input::get('crew_l2');
		$crew_r2 = Input::get('crew_r2');
		$pax_onboard = Input::get('pax_onboard');
		$pax_detail = Input::get('pax_detail');
		$mr = Input::get('mr');
		$staff_comment = Input::get('staff_comment');
		$reporting_date = $departure_date;

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
			if(CommonCheckLogic::isEmpty($report_type)){
				$this->error_message_list[] = 'Report Type' . Config::get('message.REQUIRED_ERROR');
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
			if(! CommonCheckLogic::isDate($departure_date, true) ){
				$this->error_message_list[] = 'Flight Date' . Config::get('message.DATE_FORMAT_ERROR');
			}

			// 数字チェック
			if(! CommonCheckLogic::isHalfNumericAndLength($etd, 4, true) ){
				$this->error_message_list[] = 'ETDは4桁の数値で入力してください。';
			}
			if(! CommonCheckLogic::isHalfNumericAndLength($atd, 4, true) ){
				$this->error_message_list[] = 'ATDは4桁の数値で入力してください。';
			}
			if(! CommonCheckLogic::isHalfNumericAndLength($eta, 4, true) ){
				$this->error_message_list[] = 'ETAは4桁の数値で入力してください。';
			}
			if(! CommonCheckLogic::isHalfNumericAndLength($ata, 4, true) ){
				$this->error_message_list[] = 'ATAは4桁の数値で入力してください。';
			}

			// MM + 数値チェック
			if(! CommonCheckLogic::checkFlightNumber($flight_number, true) ){
				$this->error_message_list[] = 'Flight NoはMM＋4桁の数字で入力してください。';
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
					$report_type,
					$flight_report_no,
					$added_by,
					$departure_date,
					$flight_number,
					$ship_no,
					$origin_rcd,
					$destination_rcd,
					$etd,
					$atd,
					$eta,
					$ata,
					$crew_cp,
					$crew_cap,
					$crew_r1,
					$crew_l2,
					$crew_r2,
					$pax_onboard,
					$pax_detail,
					$mr,
					$staff_comment,
					$reporting_date,
					$report_no
			];
			$data = DataManager::replaceEmptyToNull($data);

			// レポート固有情報更新
			DB::update(Config::get('sql.UPDATE_REPORT_PEACOCK'), $data);

			// カテゴリ情報削除・登録
			DataManager::deleteSelectCategoryInfo($report_no);
			DataManager::saveSelectCategoryInfo($report_no, $report_type);

			// 添付ファイル登録
			DataManager::saveAttachFile($report_no, $timestamp);
			// 添付ファイル削除
			DataManager::deleteAttachFile($report_no);
		}
		return true;
	}
}
