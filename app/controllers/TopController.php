<?php

/**
 * トップ画面
 */
class TopController extends BaseController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * トップ画面表示
	 */
	function getIndex() {

		Session::forget('SESSION_KEY_REPORT_DATA');
		Session::forget('SESSION_KEY_PREV_REPORT_PARAM');

		// モード（初期表示 or 検索)を取得
		$_mode = Session::get('_mode');
		if(! $_mode){
			$_mode = 'init';
		}

		// 照会レポート取得 ※管理者、承認者のみ
		$inquiryReport = [];
		$userRole = $this->user->userInfo->user_role;
		if($userRole == 1 || $userRole == 2){
			$inquiryReport = $this->getInquiryReport();
		}

		// 最新レポート取得
 		$newReport = $this->getNewReport();

		// 検索条件・レポート取得
		$searchCondition = new stdClass();
		$searchCondition->free_word = '';
		$searchCondition->report_class = Config::get('const.REPORT_CLASS_LIST')[$this->user->userInfo->report_name][0]['code'];
		$searchCondition->create_date_from = '';
		$searchCondition->create_date_to = '';
		$searchCondition->reporting_date_from = '';
		$searchCondition->reporting_date_to = '';
		$searchCondition->flight_date_from = '';
		$searchCondition->flight_date_to = '';
		$searchCondition->status = '';
		$searchCondition->category = '';
		$searchCondition->station = '';
		$searchCondition->area = '';
		$searchCondition->assessment = '';
		$searchCondition->first_name =  '';
		$searchCondition->last_name = '';
		$searchCondition->record_locator = '';

		$searchReport = [];
		if($_mode == 'search_success' ||
		   $_mode == 'search_error'){

			// フラッシュデータより取得
			$session_condition = Session::get('search_report_condition');
			if(count($session_condition)) {
				$searchCondition = $session_condition;
			}
			$searchReport = Session::get('search_report_list');
		}

		// レポート種別取得
		$report_class_list = SystemCodeManager::getReportClass();
		$this->settingReportClassList($report_class_list);

		// レポートステータス取得
		$report_status_list = SystemCodeManager::getReportStatus();

		// エリア取得
		$area_list = SystemCodeManager::getArea(0);

		// カテゴリ取得
		$category_list = [];
		$category_list[1] = SystemCodeManager::getCategory(1);
		$category_list[2] = SystemCodeManager::getCategory(2);
		$category_list[3] = SystemCodeManager::getCategory(3);
		$report_type_list = SystemCodeManager::getReportType(4);
		$category_list[4] = [];
		foreach($report_type_list as $report_type) {
			$category_list[4] = array_merge($category_list[4], SystemCodeManager::getCategory(4, $report_type->code2));
		}

		// ボタン取得
		$button_list = Config::get('const.REPORT_CLASS_LIST')[$this->user->userInfo->report_name];

		return View::make('top')
			->nest('parts_common_header', 'parts.common.header',['header_title' => '- ' . $this->user->userInfo->report_name, 'login_button_hidden' => ''])
			->nest('parts_common_error',  'parts.common.error',['error_message_list' => Session::get('error_message_list')])
			->nest('new_report_view', Config::get('const.topViews')[$this->user->userInfo->report_name], ['new_report_list' => $newReport, 'button_list' => $button_list])
			->with('header_title', '- ' . $this->user->userInfo->report_name)
			->with('inquiry_report_list', $inquiryReport)
			->with('search_report_condition', $searchCondition)
			->with('search_report_list', $searchReport)
			->with('report_class_list',$report_class_list)
			->with('report_status_list', $report_status_list)
			->with('area_list', $area_list)
			->with('category_list', $category_list)
			->with('_mode', $_mode);
	}


	private function settingReportClassList($report_class_list){
		$selfClass = Config::get('const.REPORT_CLASS_LIST')[$this->user->userInfo->report_name];

		foreach ($report_class_list as $row) {

			// 起票者の場合
			if($this->user->isCreator()){

				$row->disable = 'disabled="disabled"';

				for($i=0;$i < count($selfClass);$i++){
					if($row->code2 == $selfClass[$i]['code']){
						$row->disable = '';
						break;
					}
				}
			}else{
				$row->disable = '';
			}
		}
	}

	/**
	 * 検索ボタン押下時の処理
	 */
	function postSearch(){

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->userInfo->login_id,
				$this->user->getReportName() . ':トップ画面',
				'レポート検索',
				'');

		$search_free_word = Input::get('search_free_word');
		$search_report_class = Input::get('search_report_class');
		$search_create_date_from = Input::get('search_create_date_from');
		$search_create_date_to = Input::get('search_create_date_to');
		$search_reporting_date_from = Input::get('search_reporting_date_from');
		$search_reporting_date_to = Input::get('search_reporting_date_to');
		$search_flight_date_from = Input::get('search_flight_date_from');
		$search_flight_date_to = Input::get('search_flight_date_to');
		$search_status = Input::get('search_status');
		$search_category = Input::get('search_category');
		$search_station = Input::get('search_station');
		$search_area = Input::get('search_area');
		$search_assessment = Input::get('search_assessment');
		$search_first_name = Input::get('search_first_name');
		$search_last_name = Input::get('search_last_name');
		$search_record_locator = Input::get('search_record_locator');

		$searchCondition = new stdClass();
		$searchCondition->free_word = $search_free_word;
		$searchCondition->report_class = $search_report_class;
		$searchCondition->create_date_from = $search_create_date_from;
		$searchCondition->create_date_to = $search_create_date_to;
		$searchCondition->reporting_date_from = $search_reporting_date_from;
		$searchCondition->reporting_date_to = $search_reporting_date_to;
		$searchCondition->flight_date_from = $search_flight_date_from;
		$searchCondition->flight_date_to = $search_flight_date_to;
		$searchCondition->status = $search_status;
		$searchCondition->category = $search_category;
		$searchCondition->station = $search_station;
		$searchCondition->area = $search_area;
		$searchCondition->assessment = $search_assessment;
		$searchCondition->first_name =  $search_first_name;
		$searchCondition->last_name = $search_last_name;
		$searchCondition->record_locator = $search_record_locator;

		// フリーワード、検索日付のいずれかは必須入力
		if(CommonCheckLogic::isEmpty($search_free_word) &&
				CommonCheckLogic::isEmpty($search_create_date_from) &&
				CommonCheckLogic::isEmpty($search_create_date_to) &&
				CommonCheckLogic::isEmpty($search_reporting_date_from) &&
				CommonCheckLogic::isEmpty($search_reporting_date_to) &&
				CommonCheckLogic::isEmpty($search_flight_date_from) &&
				CommonCheckLogic::isEmpty($search_flight_date_to) &&
				CommonCheckLogic::isEmpty($search_status) &&
				CommonCheckLogic::isEmpty($search_category) &&
				CommonCheckLogic::isEmpty($search_station) &&
				CommonCheckLogic::isEmpty($search_area) &&
				CommonCheckLogic::isEmpty($search_assessment) &&
				CommonCheckLogic::isEmpty($search_first_name) &&
				CommonCheckLogic::isEmpty($search_last_name) &&
				CommonCheckLogic::isEmpty($search_record_locator)
				){
			$this->error_message_list[] = 'フリーワード、検索日付、検索項目のいずれかの指定が必須です。';
		}

		// 日付相関チェック
		if(CommonCheckLogic::isEitherEmpty($search_create_date_from, $search_create_date_to)){
			$this->error_message_list[] = 'Create Dateを指定する場合、From Toは双方指定が必須です。';
		}
		if(CommonCheckLogic::isEitherEmpty($search_reporting_date_from, $search_reporting_date_to)){
			$this->error_message_list[] = 'Reporting Dateを指定する場合、From Toは双方指定が必須です。';
		}
		if(CommonCheckLogic::isEitherEmpty($search_flight_date_from, $search_flight_date_to)){
			$this->error_message_list[] = 'Flight Dateを指定する場合、From Toは双方指定が必須です。';
		}

		// 日付フォーマットチェック
		if(! CommonCheckLogic::isDate($search_create_date_from, true) ){
			$this->error_message_list[] = 'Create Date（From Date）はYYYY/MM/DDで入力してください。';
		}
		if(! CommonCheckLogic::isDate($search_create_date_to, true) ){
			$this->error_message_list[] = 'Create Date（To Date）はYYYY/MM/DDで入力してください。';
		}
		if(! CommonCheckLogic::isDate($search_reporting_date_from, true) ){
			$this->error_message_list[] = 'Reporting Date（From Date）はYYYY/MM/DDで入力してください。';
		}
		if(! CommonCheckLogic::isDate($search_reporting_date_to, true) ){
			$this->error_message_list[] = 'Reporting Date（To Date）はYYYY/MM/DDで入力してください。';
		}
		if(! CommonCheckLogic::isDate($search_flight_date_from, true) ){
			$this->error_message_list[] = 'Flight Date（From Date）はYYYY/MM/DDで入力してください。';
		}
		if(! CommonCheckLogic::isDate($search_flight_date_to, true) ){
			$this->error_message_list[] = 'Flight Date（To Date）はYYYY/MM/DDで入力してください。';
		}

		// エラーがある場合
		if($this->hasError()){
 			return Redirect::to('/top')
			->with('error_message_list', $this->error_message_list)
  			->with('search_report_condition', $searchCondition)
			->withInput()
			->with('search_report_list', [])
			->with('_mode', 'search_error');
		}

		// 検索レポート取得
		$searchReport = $this->getSearchReport($searchCondition);

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/top')
			->with('error_message_list', $this->error_message_list)
 			->with('search_report_condition', $searchCondition)
			->withInput()
			->with('search_report_list', [])
			->with('_mode', 'search_error');
		}

		return Redirect::to('/top')
			->with('error_message_list', $this->error_message_list)
 			->with('search_report_condition', $searchCondition)
			->withInput()
			->with('search_report_list', $searchReport)
			->with('_mode', 'search_success');
	}

	/**
	 * 新規ボタン押下時の処理
	 */
	function postAdd(){

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->userInfo->login_id,
				$this->user->getReportName() . ':トップ画面',
				Config::get('const.REPORT_CLASS_NAME')[Input::get('_selected_report_class')] . ':新規作成',
				'');

		return Redirect::to('/report')
			->with('_mode', 'edit')
			->with('_report_no','')
			->with('_report_status','')
			->with('_report_class',Input::get('_selected_report_class'));
	}

	/**
	 * レポート選択時の処理
	 */
	function postSelect(){

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->userInfo->login_id,
				$this->user->getReportName() . ':トップ画面',
				Input::get('_inquiry_mode') === 'on' ? 'レポート照会' : 'レポート選択',
				Input::get('_selected_report_no'));


		// レポートアクセス制御チェック
		$check_result = DataManager::checkAccessControl(Input::get('_selected_report_no'), Input::get('_inquiry_mode'));
		if($check_result->result_code === false){
			// エラーメッセージ設定
			$this->error_message_list[] = $check_result->error_message;
		}

		// エラーがある場合
		if($this->hasError()){
			return Redirect::to('/top')
			->with('error_message_list', $this->error_message_list)
			->withInput()
			->with('search_report_list', [])
			->with('_mode', 'search_error');
		}

		// レポート参照　または　回答画面を開く
		$reporter_mode = $this->user->isCreator();	// 起票者モード
		$otherdept_mode = $check_result->otherdept_mode; // 他部門モード
		if(Input::get('_inquiry_mode') === 'on'){
			$inqmode = 'answer';
		}else if($otherdept_mode){
			$inqmode = 'other';
		}else{
			$inqmode = 'reference';
		}

		return Redirect::to('/report')
// 				->with('_mode', (Input::get('_inquiry_mode') == 'on' ? 'answer' : 'reference'))
				->with('_mode', $inqmode)
				->with('_report_no',Input::get('_selected_report_no'))
				->with('_report_status', Input::get('_selected_report_status'))
				->with('_report_class',Input::get('_selected_report_class'));
	}

	/**
	 * レポートプレビュー時の処理
	 */
	function postPreview() {

		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->userInfo->login_id,
				$this->user->getReportName() . ':トップ画面',
				'レポートプレビュー',
				Input::get('_selected_report_no'));

		// レポートアクセス制御チェック
		$check_result = DataManager::checkAccessControl(Input::get('_selected_report_no'));
		if($check_result->result_code === false){
			// エラーメッセージ設定
			$this->error_message_list[] = $check_result->error_message;
		}

		return Redirect::to('/preview')
				->with('error_message_list', $this->error_message_list)
				->with('_report_no',Input::get('_selected_report_no'))
				->with('_report_status', Input::get('_selected_report_status'))
				->with('_report_class',Input::get('_selected_report_class'));
	}

	/**
	 * アラート設定ボタン押下時
	 */
	function postAlert() {
		// 操作履歴ログ出力
		DataManager::registerOperationLog(
				$this->user->userInfo->login_id,
				$this->user->getReportName() . ':トップ画面',
				'アラート設定',
				'');

		return Redirect::to('/alert');
	}

	/**
	 * 照会レポート取得処理
	 */
	protected function getInquiryReport(){
		throw new Exception('未実装');
	}

	/**
	 * 最新レポート取得処理
	 */
	protected function getNewReport(){
		throw new Exception('未実装');
	}

	/**
	 * 検索レポート取得処理
	 */
	protected function getSearchReport($searchCondition){

		$sqlString = '';
		$whereString = '';
		$bindParam = [];
		$report_name = $this->user->userInfo->report_name;
		$reporter_mode = $this->user->isCreator();

		$bindParam[] = $searchCondition->report_class;
		Log::info($searchCondition->report_class);
		$bindParam[] = '1';

		//  ログインユーザ：他部門指定時は公開レポートのみ
		$search_reportName = Config::get('const.REPORT_CLASS_NAME')[$searchCondition->report_class];
		if($report_name !== $search_reportName){
			$whereString .= 'and t1.own_department_only_flag <> 1 ';
		}

		// ログインユーザ：PEREGRINE部門(起票者)の場合、自空港のみ限定
		if($reporter_mode && 'PEREGRINE' === $report_name){
			// 指定レポート：PEACOCK
			if(Config::get('const.REPORT_CLASS.PEACOCK') == $searchCondition->report_class){
				$whereString .= 'and false ';	// 空港情報がないため検索不可
			}else{
				$station = $this->user->userInfo->station;
				if(empty($station)){
					$station = '';	// 自空港未設定の場合
				}
				$whereString .= 'and t2.station = ? ';
				$bindParam[] = $station;
			}
		}

		// report種別モード
		$search_mode = '';
		if(Config::get('const.REPORT_CLASS.PENGUIN') == $searchCondition->report_class){
			$search_mode = 'PENGUIN';
		}else if(Config::get('const.REPORT_CLASS.PEREGRINE_Incident') == $searchCondition->report_class ||
					Config::get('const.REPORT_CLASS.PEREGRINE_Irregularity') == $searchCondition->report_class){
			$search_mode = 'PEREGRINE';
		}else if (Config::get('const.REPORT_CLASS.PEACOCK') == $searchCondition->report_class){
			$search_mode = 'PEACOCK';
		}

		// SQL本文
		if($search_mode == 'PENGUIN'){
			$sqlString = Config::get('sql.SELECT_SEARCH_REPORT_PENGUIN');
		}else if($search_mode == 'PEREGRINE'){
			$sqlString = Config::get('sql.SELECT_SEARCH_REPORT_PEREGRINE');
		}else if ($search_mode == 'PEACOCK'){
			$sqlString = Config::get('sql.SELECT_SEARCH_REPORT_PEACOCK');
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->free_word) ){

			if($search_mode == 'PENGUIN'){
				$whereString .= 'and (t1.report_no like ? or t2.flight_number like ? or t2.flight_number_2 like ? or t1.contents like ?) ';
				$bindParam[] = '%' . $searchCondition->free_word . '%';
				$bindParam[] = '%' . $searchCondition->free_word . '%';
				$bindParam[] = '%' . $searchCondition->free_word . '%';
				$bindParam[] = '%' . $searchCondition->free_word . '%';

			}else{
				$whereString .= 'and (t1.report_no like ? or t2.flight_number like ? or t1.contents like ?) ';
				$bindParam[] = '%' . $searchCondition->free_word . '%';
				$bindParam[] = '%' . $searchCondition->free_word . '%';
				$bindParam[] = '%' . $searchCondition->free_word . '%';
			}
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->create_date_from) ){

			$whereString = $whereString . ' and DATE_FORMAT(t1.create_timestamp, \'%Y/%m/%d\') between ? and ?';

			$bindParam[] = $searchCondition->create_date_from;
			$bindParam[] = $searchCondition->create_date_to;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->reporting_date_from) ){
			if($search_mode == 'PENGUIN'){
				$whereString = $whereString . ' and DATE_FORMAT(t2.first_contatct_date, \'%Y/%m/%d\') between ? and ?';
			}else{
				$whereString = $whereString . ' and DATE_FORMAT(t2.reporting_date, \'%Y/%m/%d\') between ? and ?';
			}
			$bindParam[] = $searchCondition->reporting_date_from;
			$bindParam[] = $searchCondition->reporting_date_to;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->flight_date_from) ){
			if($search_mode == 'PENGUIN'){
				//レポート種別PENGUINの場合、搭乗日２も対象
				$whereString = $whereString . ' and (DATE_FORMAT(t2.departure_date, \'%Y/%m/%d\') between ? and ?';
				$whereString = $whereString . ' or DATE_FORMAT(t2.departure_date_2, \'%Y/%m/%d\') between ? and ? )';
				$bindParam[] = $searchCondition->flight_date_from;
				$bindParam[] = $searchCondition->flight_date_to;
				$bindParam[] = $searchCondition->flight_date_from;
				$bindParam[] = $searchCondition->flight_date_to;
			}else{
				$whereString = $whereString . ' and DATE_FORMAT(t2.departure_date, \'%Y/%m/%d\') between ? and ?';
				$bindParam[] = $searchCondition->flight_date_from;
				$bindParam[] = $searchCondition->flight_date_to;
			}
		}

		if(! CommonCHeckLogic::isEmpty($searchCondition->status)) {
			$whereString .= ' and t1.report_status = ?';
			$bindParam[] = $searchCondition->status;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->category)) {
			if($this->user->userInfo->report_name == 'PEACOCK') {
				$whereString .= ' and t1.report_no IN (select report_no from select_category_info where category = ?)';
			} else {
				$whereString .= ' and t2.category = ?';
			}
			$bindParam[] = $searchCondition->category;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->station)) {
			$search_station = str_replace(' ', ',', trim($searchCondition->station));
			$whereString .= ' and FIND_IN_SET(t2.station, ?)';
			$bindParam[] = $search_station;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->area)) {
			$whereString .= ' and t2.area = ?';
			$bindParam[] = $searchCondition->area;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->assessment)) {
			$whereString .= ' and assessment = ?';
			$bindParam[] = $searchCondition->assessment;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->first_name)) {
			$first_name = "%{$searchCondition->first_name}%";
			$whereString .= ' and (t1.firstname LIKE ? or t1.firstname_2 LIKE ? or t1.firstname_3 LIKE ?)';
			$bindParam[] = $first_name;
			$bindParam[] = $first_name;
			$bindParam[] = $first_name;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->last_name)) {
			$last_name = "%{$searchCondition->last_name}%";
			$whereString .= ' and (t1.lastname LIKE ? or t1.lastname_2 LIKE ? or t1.lastname_3 LIKE ?)';
			$bindParam[] = $last_name;
			$bindParam[] = $last_name;
			$bindParam[] = $last_name;
		}

		if(! CommonCheckLogic::isEmpty($searchCondition->record_locator)) {
			$whereString .= ' and (record_locator = ? or record_locator_2 = ? or record_locator_3 = ?)';
			$bindParam[] = $searchCondition->record_locator;
			$bindParam[] = $searchCondition->record_locator;
			$bindParam[] = $searchCondition->record_locator;
		}

		$countSqlString = preg_replace ('/select.*from/','select count(t1.report_no) count from',$sqlString);

		$result = DB::selectOne($countSqlString . $whereString,$bindParam);

		if($result->count == 0){
			$this->error_message_list[] = '検索条件に該当するレポートはありませんでした。';
			return null;
		}

		if($result->count > 100){
			$this->error_message_list[] = '検索結果が100件を超えています。検索範囲を絞り込み再検索してください。';
			return null;
		}

		$result = DB::select(
				$sqlString
				. $whereString
				. ' order by t1.update_timestamp desc',
				$bindParam
		);
		return $result;
	}
}
