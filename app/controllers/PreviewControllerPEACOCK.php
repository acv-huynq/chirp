<?php

/**
 *
 * プレビュー画面（PEACOCK）
 *
 */
class PreviewControllerPEACOCK extends PreviewController {

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
		return DB::selectOne(Config::get('sql.SELECT_PREVIEW_PEACOCK'),['1','1', $report_no, '1']);
	}
}
