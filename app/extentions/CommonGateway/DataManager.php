<?php

namespace CommonGateway {

	use DB;
	use Log;
	use Config;
	use DateUtil;
	use PDOException;
	use CommonCheckLogic;
	use Input;
	use App;
	use Session;

	class DataManager {


		/**
		 * コンストラクタ
		 */
		function __construct() {

		}

		/**
		 * データ登録
		 * @param unknown $sql
		 * @param unknown $data
		 * @throws PDOException
		 * @return boolean
		 */
		function insertWithCheckDuplicate($sql, $data){

			try{
				// レポート基本情報登録
				$count = DB::insert(
						$sql,
						$data
				);
				return false;

			}catch(PDOException $e){
				// キー重複
				if($e->getCode() === '23000'){
					return true;

				}
				throw $e;
			}
			return false;
		}

		/**
		 * ユーザー情報取得
		 */
		function getUserInfo($login_id){

			$result = DB::selectOne(
					Config::get('sql.SELECT_USER_INFO'),
					[$login_id]
			);
			return $result;
		}

		/**
		 * 添付ファイル登録
		 * @param string $report_no レポート番号
		 * @param datetime $create_timestamp 日時
		 */
		function saveAttachFile($report_no, $create_timestamp){

			for($i = 1; $i <= 5; $i++){

				$attach_file = Input::file('attach_file_' . $i);

				if($attach_file){

					$data = [
							$report_no,
							$attach_file->getClientOriginalName(),
							file_get_contents($attach_file->getRealPath()),
							$create_timestamp,
							$report_no
					];
					DB::insert(Config::get('sql.INSERT_REPORT_ATTACHE_FILE'), $data);
				}
			}
		}

		/**
		 * 添付ファイル削除
		 * @param string $report_no レポート番号
		 */
		function deleteAttachFile($report_no){


			$count = Input::get('attache_file_count');

			for($i = 1; $i <= $count; $i++){

				$file_seq = Input::get('delete_file_' . $i);

				if($file_seq){
					DB::delete(Config::get('sql.DELETE_REPORT_ATTACHE_FILE'), [$report_no, $file_seq]);
				}
			}
		}

		/**
		 * 選択カテゴリ情報取得
		 * @param string $report_no レポート番号
		 */
		function getSelectCategoryInfo($report_no){
			return DB::select(Config::get('sql.SELECT_SELECT_CATEGORY_INFO'), [$report_no]);
		}

		/**
		 * 選択カテゴリ情報削除
		 * @param string $report_no レポート番号
		 */
		function deleteSelectCategoryInfo($report_no){
			DB::delete(Config::get('sql.DELETE_SELECT_CATEGORY_INFO'), [$report_no]);
		}

		/**
		 * 選択カテゴリ情報登録
		 * @param string $report_no レポート番号
		 * @param int $report_type レポート種別
		 */
		function saveSelectCategoryInfo($report_no, $report_type){

			$count = Input::get('category_list_count');

			for($i = 1; $i <= $count; $i++){

				$category = Input::get('category_' . $i);

				if($category){
					$data = [
							$report_no,
							$report_type,
							$category
					];
					DB::insert(Config::get('sql.INSERT_SELECT_CATEGORY_INFO'), $data);
				}
			}
		}

		/**
		 * コメント連番採番
		 * @param string $report_no
		 * @return コメント連番
		 */
		function createCommentSeq($report_no){
			return DB::selectOne(Config::get('sql.SELECT_MAX_COMMENT_SEQ'),[$report_no])->comment_seq;
		}

		/**
		 * ファイル連番採番
		 * @param string $report_no
		 * @return ファイル連番
		 */
		function createFileSeq($report_no){
			return DB::selectOne(Config::get('sql.SELECT_MAX_FILE_SEQ'), [$report_no])->file_seq;
		}

		/**
		 * コメント一覧取得
		 * @param string $report_no レポート番号
		 * @param int $report_seq レポート連番
		 */
		function getCommentList($report_no){
			return DB::select(Config::get('sql.SELECT_REPORT_COMMENT'),[$report_no]);
		}

		/**
		 * レポート番号採番
		 */
		function getReportNoAndSeq($report_class, $option, $departure_date = ''){

			$reportNo = 1;
			$searchKey;
			$reportNoPrefix = '';
			$businessYear = $this->getBusinessYear($departure_date);

			switch ($report_class){

				// PENGUIN
				case 1:

					// StationがCRの場合
					if($option === 'CR'){
						$searchKey = 'HQ' . $option . $businessYear . '-%';
						$reportNoPrefix = 'HQ' . $option;

					// TYO, FUKの場合
					}else{

						$searchKey = 'C' . $option . $businessYear . '-%';
						$reportNoPrefix = 'C' . $option;
					}
					break;

				// PEREGRINE Irregularity
				case 2:

					$searchKey = 'R' . $option . $businessYear . '-%';
					$reportNoPrefix = 'R' . $option;
					break;

				// PEREGRINE Incident
				case 3:

					$searchKey = 'N' . $option . $businessYear . '-%';
					$reportNoPrefix = 'N' . $option;
					break;

				// PEACOCK
				case 4:

					$searchKey = 'CA' . $option . $businessYear . '-%';
					$reportNoPrefix = 'CA' . $option;
					break;

				default:

					throw Exception('Invalid Argument report class:' . $report_class . ' option:' . $option );
			}

			$report_seq = DB::selectOne(Config::get('sql.SELECT_MAX_REPORT_SEQ'),[$searchKey])->report_seq;
			$report_seq = $this->formatNumber($report_seq, '05');
			return [$reportNoPrefix . $businessYear . '-' .  $report_seq, $report_seq];
		}




		/**
		 * 年度取得
		 */
		private function getBusinessYear($departure_date){

			if(!empty($departure_date)) {
				$standard_date = $departure_date;
			} else {
				$standard_date = date("Y/m/d");
			}

			$year  = date('Y', strtotime($standard_date));
			$month = date('n', strtotime($standard_date));

			if($month < 4){
				$year--;
			}
			return $this->formatNumber($year, '04');
		}

		/**
		 * 値を指定桁にフォーマットする
		 * @param string $value 値
		 * @param string $lengthValue 指定桁
		 * @return 指定桁の値
		 */
		private function formatNumber($value, $lengthValue){
			return sprintf('%' . $lengthValue . 'd', $value);
		}

		/**
		 * 権限管理情報取得
		 */
		function getRoleManageinfo($mode, $user_role, $report_status){

			switch($report_status) {
				case Config::get('const.REPORT_STATUS.PASSBACK_SUBMITTED'):
					$report_status = Config::get('const.REPORT_STATUS.CREATED');
					break;
				case Config::get('const.REPORT_STATUS.RESUBMIT'):
				case Config::get('const.REPORT_STATUS.PASSBACK_CONFIRMED'):
					$report_status = Config::get('const.REPORT_STATUS.SUBMITTED');
					break;
				case Config::get('const.REPORT_STATUS.RECONFIRM'):
					$report_status = Config::get('const.REPORT_STATUS.CONFIRMED');
					break;
			}

			$result = DB::selectOne(
					"select "
					. 'id, '
					."case when edit_button_hidden = '1' then 'hidden-element' else '' end edit_button_hidden,"
					."case when cancel_button_hidden = '1' then 'hidden-element' else '' end cancel_button_hidden,"
					."case when save_button_hidden = '1' then 'hidden-element' else '' end save_button_hidden,"
					."case when submit_button_hidden = '1' then 'hidden-element' else '' end submit_button_hidden,"
					."case when confirm_button_hidden = '1' then 'hidden-element' else '' end confirm_button_hidden,"
					."case when close_button_hidden = '1' then 'hidden-element' else '' end close_button_hidden,"
					."case when inquiry_button_hidden = '1' then 'hidden-element' else '' end inquiry_button_hidden,"
					."case when inquiry_save_button_hidden = '1' then 'hidden-element' else '' end inquiry_save_button_hidden,"
					."case when answer_save_button_hidden = '1' then 'hidden-element' else '' end answer_save_button_hidden,"
					."case when passback_button_hidden = '1' then 'hidden-element' else '' end passback_button_hidden,"
					."case when delete_button_hidden = '1' then 'hidden-element' else '' end delete_button_hidden,"
					."case when comment_button_hidden = '1' then 'hidden-element' else '' end comment_button_hidden,"
					."case when reservation_info_button_hidden = '1' then 'hidden-element' else '' end reservation_info_button_hidden,"
					."case when pax_info_button_hidden = '1' then 'hidden-element' else '' end pax_info_button_hidden,"
					."case when add_attach_file_button_hidden = '1' then 'hidden-element' else '' end add_attach_file_button_hidden,"
					."case when delete_attach_file_button_hidden = '1' then 'hidden-element' else '' end delete_attach_file_button_hidden,"
					."case when send_mail_creator_hidden = '1' and send_mail_administrator_group_hidden = '1' and send_mail_approver_group_hidden = '1' and send_mail_inquiry_from_administrator_group_hidden = '1' and send_mail_inquiry_to_administrator_group_hidden = '1' then 'hidden-element' else '' end send_mail_area_hidden, "
					."case when send_mail_creator_hidden = '1' then 'hidden-element' else '' end send_mail_creator_hidden,"
					."case when send_mail_administrator_group_hidden = '1' then 'hidden-element' else '' end send_mail_administrator_group_hidden,"
					."case when send_mail_approver_group_hidden = '1' then 'hidden-element' else '' end send_mail_approver_group_hidden,"
					."case when send_mail_inquiry_from_administrator_group_hidden = '1' then 'hidden-element' else '' end send_mail_inquiry_from_administrator_group_hidden,"
					."case when send_mail_inquiry_from_administrator_group_hidden = '1' then '' else 'checked=\"checked\"' end send_mail_inquiry_from_administrator_group_checked,"
					."case when send_mail_inquiry_to_administrator_group_hidden = '1' then 'hidden-element' else '' end send_mail_inquiry_to_administrator_group_hidden,"
					."case when remarks_disabled = '1' then 'disabled=\"disabled\"' else '' end remarks_disabled,"
					."case when other_input_disabled = '1' then 'disabled=\"disabled\"' else '' end other_input_disabled,"
					."case when comment_area_hidden = '1' then 'hidden-element' else '' end comment_area_hidden,"
					."case when related_report_area_hidden = '1' then 'hidden-element' else '' end related_report_area_hidden, "
					."case when answer_read_hidden = '1' then 'hidden-element' else '' end answer_read_hidden, "
					."case when report_alert_hidden = '1' then 'hidden-element' else '' end report_alert_hidden "
					." from mst_role_manage "
					."where mode = ? and user_role = ? and report_status = ?",
					[$mode, $user_role, $report_status]
			);

			return $result;

		}

		/**
		 * 操作履歴登録
		 *
		 * @param string $loginId ログインID
		 * @param string $screenName 画面名
		 * @param string $action アクション
		 * @param int $reportNo レポート番号
		 */
		function registerOperationLog($loginId, $screenName, $action, $reportNo){

			Log::info('[loginId=' . $loginId . '] - [screenName=' . $screenName . '] - [action=' . $action . '] - [reportNo=' . $reportNo . ']');

			DB::insert(
				'insert into operation_history (operation_timestamp,login_id,screen_name,action,report_no) '
				.' values(?,?,?,?,?)',
				[ DateUtil::getCurrentTimestamp(), $loginId, $screenName, $action, $reportNo]
			);
		}

		/**
		 * ブランクをNULLに置換する
		 * @param  array $array 置換対象リスト
		 * @return 置換済リスト:
		 */
		function  replaceEmptyToNull($array) {
			$result = [];
			foreach($array as $item) {
				if(trim($item) == '') {
					array_push($result,NULL);
				} else {
					array_push($result,$item);
				}
			}
			return $result;
		}

		/**
		 * アクセス制御チェック処理
		 * @param $report_no レポートNO
		 * @param $inquiry_flg 照会フラグ(on/on以外)
		 * @return $result[stdClass]
		 *                result_code(true:OK false:エラー)
		 *                error_message(エラーメッセージ)
		 *                otherdept_mode(他部門モード true:他部門 false:自部門)
		 */
		function checkAccessControl($report_no, $inquiry_flg = 'off'){
			App::bind('checkAccessControlResult', 'stdClass');
			$result = app('checkAccessControlResult');	// 結果クラス
			// 結果初期値
			$result->result_code = true;
			$result->error_message = '';

			// ユーザー情報取得
			$userData = unserialize(Session::get('SESSION_KEY_CHIRP_USER'));
			// レポート情報取得
			$sqlString = 'SELECT report_class, peacock_inquiry_status, penguin_inquiry_status, peregrine_inquiry_status, own_department_only_flag, delete_flag, t2.station '
						. 'FROM report_basic_info AS t1 '
						. 'LEFT OUTER JOIN report_info_peregrine AS t2 ON t1.report_no = t2.report_no '
						. 'WHERE t1.report_no = ? ';
			$checkresult = DB::selectOne(
					$sqlString,
					[$report_no]
			);

			//レポート情報
			$report_class = $checkresult->report_class;
			$own_flg = $checkresult->own_department_only_flag;
			$del_fig = $checkresult->delete_flag;

			$report_name = $userData->userInfo->report_name;
			$inquiry_status = '';
			if('PEACOCK' === $report_name){
				$inquiry_status = $checkresult->peacock_inquiry_status;
			}else if('PENGUIN' === $report_name){
				$inquiry_status = $checkresult->penguin_inquiry_status;
			}else if('PEREGRINE' === $report_name){
				$inquiry_status = $checkresult->peregrine_inquiry_status;
			}

			$inquiry_mode = $inquiry_flg == 'on';	// 照会モード
			$otherdept_mode = Config::get('const.REPORT_CLASS_BASIC_NAME')[$report_class] != $report_name; // 他部門モード
			$reporter_mode = Config::get('const.USER_ROLE.REPORTER') === intVal($userData->userInfo->user_role);	// 起票者モード

			if($del_fig === '1'){
				// 照会・リポートリンク（削除済）
				$result->result_code = false;
				$result->error_message = '選択したレポートはすでに削除されています。';
			}else if($inquiry_mode){
				// 照会リンク
				if($inquiry_status === '2'){
					// 回答済
					$result->result_code = false;
					$result->error_message = '選択したレポートはすでに回答されています。';
				}
			}else if(!$inquiry_mode){
				// レポートリンク
				// ログインユーザ：起票者の場合、他部門・非公開はエラー
				if(($reporter_mode && $otherdept_mode) || ($otherdept_mode && $own_flg === '1')){
					$result->result_code = false;
					$result->error_message = '選択したレポートへの参照権限がありません。';
				} else if ($reporter_mode && 'PEREGRINE' === $report_name) {
					if ($userData->userInfo->station !== $checkresult->station){
						$result->result_code = false;
						$result->error_message = '選択したレポートへの参照権限がありません。';
					}

				}
			}

			// 他部門モード
			$result->otherdept_mode = $otherdept_mode;

			return $result;
		}

		/**
		 * レポート個別アラート設定判定
		 * @param unknown $login_id
		 * @param unknown $report_no
		 */
		function isReportAlert($login_id, $report_no) {

			$cnt = DB::table('alert_mail_condition')
				->where('login_id', $login_id)
				->where('report_no', $report_no)
				->count();

			return $cnt;
		}

	}
}