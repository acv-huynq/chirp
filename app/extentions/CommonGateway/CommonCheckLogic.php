<?php

namespace CommonGateway {

	use DB;
	use Config;

	class CommonCheckLogic {

		/**
		 * 未入力チェック
		 * @param string $value
		 * @return boolean チェック結果(true:未入力、false:入力あり)
		 */
		public function isEmpty($value){
			return ($value == null || trim($value) == '');
		}

		/**
		 * 未入力チェック（どちらか一方のみ）
		 * @param string $value
		 * @return boolean チェック結果(true:どちらか一方のみ未入力、false:双方入力あり or 双方未入力)
		 */
		public function isEitherEmpty($value1, $value2){

			return ($this->isEmpty($value1) && !$this->isEmpty($value2)) ||
					($this->isEmpty($value2) && !$this->isEmpty($value1));
		}

		/**
		 * 数値チェック
		 * @param int $value
		 * @return boolean チェック結果(true:半角数字、false:半角数字以外)
		 * @return boolean チェック結果(true:数値、false:数値以外)
		 */
		public function isNumeric($value, $ignoreEmpty) {

			if($ignoreEmpty && $this->isEmpty($value)){
				return true;
			}

			return is_numeric($value);
		}

		/**
		 * 半角数字チェック
		 * @param string $value
		 * @return boolean チェック結果(true:半角数字、false:半角数字以外)
		 */
		public function isHalfNumeric($value) {
			return preg_match("/^[0-9]+$/", $value);
		}

		/**
		 * 半角数字チェック(固定桁数)
		 * @param string $value
		 * @param int $length
		 * @param boolean $ignoreEmpty 空文字無視フラグ
		 * @return boolean チェック結果(true:半角数字、false:半角数字以外)
		 */
		public function isHalfNumericAndLength($value, $length, $ignoreEmpty) {

			if($ignoreEmpty && $this->isEmpty($value)){
				return true;
			}
			return preg_match("/^[0-9]+$/", $value) && strlen($value) == $length;
		}

		/**
		 * 便名のフォーマットチェック
		 * @param unknown $value
		 * @param boolean $ignoreEmpty 空文字無視フラグ
		 */
		public function checkFlightNumber($value, $ignoreEmpty){

			if($ignoreEmpty && $this->isEmpty($value)){
				return true;
			}
			return preg_match("/^MM\d{4}+$/", $value);
		}


		/**
		 * 半角英数字チェック
		 * @param string $value
		 * @param boolean $ignoreEmpty 空文字無視フラグ
		 * @return boolean チェック結果(true:半角英数字、false:半角英数字以外)
		 */
		public function isHalfAlphaNumeric($value, $ignoreEmpty){

			if($ignoreEmpty && $this->isEmpty($value)){
				return true;
			}
			return preg_match("/^[a-zA-Z0-9]+$/", $value);
		}

		/**
		 * 日付チェック
		 * @param string $date 日付文字列
		 * @param boolean $ignoreEmpty 空文字無視フラグ
		 * @return boolean チェック結果
		 */
		public function isDate($date, $ignoreEmpty) {

			if($ignoreEmpty && $this->isEmpty($date)){
				return true;
			}

			// 区切り文字で年、月、日を分ける
			$array = explode('/', $date);
			if(count($array) == 3) {
				$year  = intval($array[0]);
				$month = intval($array[1]);
				$day   = intval($array[2]);
			} else {
				return false;
			}

			// 年月日の文字数が正しいか
			if(mb_strlen($year) != 4) {
				return false;
			}
			if(mb_strlen($month) != 2 && mb_strlen($month) != 1) {
				return false;
			}
			if(mb_strlen($day) != 2 && mb_strlen($day) != 1) {
				return false;
			}

			// 日付として正しいかどうか
			return checkdate ($month,$day,$year);
		}

		/**
		 * メール送信先の選択が正しいかどうか
		 * @param unknown $mode
		 * @param unknown $button_name
		 * @param unknown $checks
		 * @return boolean
		 */
		public function checkSendMail($mode, $button_name, $checks){

			$reult = true;

			switch ($mode){
				case 'confirm':

					if($button_name === 'passback' &&
						$checks[2] === 'on'){

							$reult = false;
					}
					if($button_name === 'confirm' &&
							$checks[0] === 'on'){

						$reult = false;
					}
					break;
				case 'close':

					if($button_name === 'passback' &&
							$checks[0] === 'on'){

						$reult = false;
					}
					break;
				case 'inquiry':

					if($button_name === 'inquiry'){

						$reult = false;
						for($i=0;$i < count($checks)-1; $i++){

							if($checks[$i] === 'on'){
								$reult = true;
								break;
							}
						}
					}

					break;
				default:
					break;
			}
			return $reult;
		}

		/**
		 * レポート存在チェック
		 * @param unknown $report_no レポート番号
		 * @param boolean $ignoreEmpty 空文字無視フラグ
		 */
		function isExsistsReport($report_no, $ignoreEmpty){

			if($ignoreEmpty && $this->isEmpty($report_no)){
				return true;
			}

			$result = DB::selectOne(Config::get('sql.EXSISTS_REPORT'),[$report_no, 1]);
			return $result->count > 0;
		}

	}
}
