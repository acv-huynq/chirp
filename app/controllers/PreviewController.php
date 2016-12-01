<?php

/**
 * プレビュー画面
 */
class PreviewController extends BaseController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * プレビュー画面表示
	 */
	function getIndex() {

		$error_message_list = Session::get('error_message_list');
		$report_no = Session::get('_report_no');
		$report_class = Session::get('_report_class');
		$modified = Session::get('_modified');

		// エラーがある場合
		if(count($error_message_list)) {
			return View::make('preview')
			->with('error_message_list', $error_message_list)
			->with('header_title', '- ' . Config::get('const.REPORT_CLASS_NAME')[$report_class]);
		}

		$report_info = $this->getReportInfo($report_no);
		$report_info->attach_file_list = $this->getAttacheFileList($report_no);

		$related_report_arr = [];
		if(strlen($report_info->related_report_no)) {
			$related_report_arr[] = $report_info->related_report_no;
		}
		if(strlen($report_info->related_report_no_2)) {
			$related_report_arr[] = $report_info->related_report_no_2;
		}

		$report_info->related_report_list = implode(', ', $related_report_arr);

		return View::make('preview')
		->with('error_message_list', $error_message_list)
		->with('header_title', '- ' . Config::get('const.REPORT_CLASS_BASIC_NAME')[$report_class])
		->with('report_title', '- ' . Config::get('const.REPORT_CLASS_NAME')[$report_class])
		->nest('parts_preview', Config::get('const.previewViews')[$report_class], ['report_info' => $report_info]);
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
	 * 添付ファイル一覧取得
	 * @param unknown $report_no
	 */
	function getAttacheFileList($report_no){
		$result = DB::select(Config::get('sql.SELECT_REPORT_ATTACHE_FILE_LIST'), [$report_no]);

		$attach_file_arr = [];

		foreach($result as $attach_file) {
			$attach_file_arr[] = $attach_file->file_name;
		}

		return implode(', ', $attach_file_arr);
	}


}
