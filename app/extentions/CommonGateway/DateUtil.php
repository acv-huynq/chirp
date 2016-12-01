<?php

namespace CommonGateway {

	class DateUtil {

		/**
		 * コンストラクタ
		 */
		function __construct() {

		}

		/**
		 * 現在日時を取得する
		 */
		function getCurrentTimestamp(){
			return date("Y-m-d H:i:s");
		}
	}
}
