<?php

/**
 *
 * プレビュー画面（PENGUIN）
 *
 */
class PreviewControllerPENGUIN extends PreviewController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * レポート情報取得
	 * @see PreviewController::getReportInfo()
	 */
	protected function getReportInfo($report_no){
		return DB::selectOne(Config::get('sql.SELECT_PREVIEW_PENGUIN'),['1','1', 'Sub Category' ,$report_no, '1']);
	}
}
