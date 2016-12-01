<?php

	class ChirpUser{

		public $userInfo;

		/*
		 * コンストラクタ
		 */
		function __construct($userInfo) {

			$this->userInfo = $userInfo;
		}

		/**
		 * 起票者かどうかを返す
		 * @return boolean
		 */
		function isCreator(){
			return intVal($this->userInfo->user_role) === Config::get('const.USER_ROLE.REPORTER');
		}

		/**
		 * ログインID取得
		 */
		function getLoginId(){
			return $this->userInfo->login_id;
		}

		/**
		 * Station取得
		 */
		function getStation(){
			return $this->userInfo->station;
		}

		/**
		 * レポート名取得
		 */
		function getReportName(){
			return $this->userInfo->report_name;
		}
	}
