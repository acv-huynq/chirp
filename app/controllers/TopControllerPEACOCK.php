<?php

/**
 * トップ画面（PEACOCK）
 */
class TopControllerPEACOCK extends TopController {

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
				Config::get('sql.SELECT_INQUIRY_REPORT_PEACOCK'),
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

		$result = DB::select(
				Config::get('sql.SELECT_NEW_REPORT_PEACOCK'),
				[
					Config::get('const.REPORT_CLASS.PEACOCK'),	// PEACOCKのみ
					Config::get('const.REPORT_STATUS.CLOSE'),	// 承認済以外
					'1'
				]
		);
		return $result;
	}

}
