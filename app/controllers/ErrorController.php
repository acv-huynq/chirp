<?php

/**
 * エラー画面
 */
class ErrorController extends BaseController {

	/**
	 * コンストラクタ
	 */
	function __construct() {
		$this->requireAuth = false;
		parent::__construct();
	}

	/**
	 * エラー画面表示
	 */
	function getIndex() {

		return View::make('error');
	}
}
