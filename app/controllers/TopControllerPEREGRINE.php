<?php

/**
 * トップ画面（PEREGRINE）
 */
class TopControllerPEREGRINE extends TopController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * 照会レポート取得処理
	 * @see TopController::getInquiryReport()
	 */
	protected function getInquiryReport(){

		return DB::select(
				Config::get('sql.SELECT_INQUIRY_REPORT_PEREGRINE'),
				[
					Config::get('const.INQUIRY_STATUS.INQUIRY'),
					'1'
				]
		);
	}

	/**
	 * 最新レポート取得処理
	 * @see TopController::getNewReport()
	 */
	protected function getNewReport(){
		// PEREGRINEは2テーブル
		$station = $this->user->userInfo->station;

		$sqlString = Config::get('sql.SELECT_NEW_REPORT_PEREGRINE');
		$whereString = '';
		$orderString = 'order by t1.update_timestamp desc ';
		$bindParam_Incident = [
											Config::get('const.REPORT_CLASS.PEREGRINE_Incident'),	// PEREGRINE_Incidentのみ
											Config::get('const.REPORT_STATUS.CLOSE'),	// 承認済以外
											'1'
											];

		$bindParam_Irregularity = [
												Config::get('const.REPORT_CLASS.PEREGRINE_Irregularity'),	// PEREGRINE_Irregularityのみ
												Config::get('const.REPORT_STATUS.CLOSE'),	// 承認済以外
												'1'
												];

		if($this->user->isCreator()){
			// 起票者の場合
			$whereString = 'and t2.station = ? ';
			$bindParam_Incident[] = $station;
			$bindParam_Irregularity[] = $station;
		}

		// PEREGRINE_Incident
		$result['Incident'] = DB::select(
				$sqlString.$whereString.$orderString,
				$bindParam_Incident
		);
		// PEREGRINE_Irregularity
		$result['Irregularity'] = DB::select(
				$sqlString.$whereString.$orderString,
				$bindParam_Irregularity
		);
		return $result;
	}

}
