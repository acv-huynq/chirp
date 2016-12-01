<?php

/**
 *
 * プレビュー画面（PEREGRINE）
 *
 */
class PreviewControllerPEREGRINE extends PreviewController {

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
		return DB::selectOne(Config::get('sql.SELECT_PREVIEW_PEREGRINE'),['1','1', $report_no, '1']);
	}
}
