<?php

namespace CommonGateway {

	use DB;
	use Log;


	class SystemCodeManager {


		private static $sql = 'select t2.code2, t2.value2 from mst_system_code_category t1 inner join mst_system_code t2 on t1.code1 = t2.code1 where  t1.code1 = ? and (t2.report_class = ? or t2.report_class = "0") order by t2.disp_order';

		/**
		 * コンストラクタ
		 */
		function __construct() {

		}

		/**
		 * 性別取得
		 */
		function getGender(){
			$result = DB::select(
					self::$sql,
					['gender', 0]
			);
			return $result;
		}

		/**
		 * レポートタイプ取得
		 */
		function getReportType($reportClass){
			$result = DB::select(
					self::$sql,
					['Report Type', $reportClass]
			);
			return $result;
		}

		/**
		 * レポート種別取得
		 */
		function getReportClass(){
			$result = DB::select(
					self::$sql,
					['Report Class', 0]
			);
			return $result;
		}

		/**
		 * Ship No取得
		 */
		function getShipNo($reportClass){
			$result = DB::select(
					self::$sql,
					['Ship No', $reportClass]
			);
			return $result;
		}

		/**
		 * Sector取得
		 */
		function getSector($reportClass){
			$result = DB::select(
					self::$sql,
					['Sector', $reportClass]
			);
			return $result;
		}

		/**
		 * Phoenix class取得
		 */
		function getPhoenixClass ($reportClass){
			$result = DB::select(
					self::$sql,
					['Phoenix class', $reportClass]
			);
			return $result;
		}

		/**
		 * カテゴリ取得
		 */
		function getCategory($reportClass, $categoryOption = null){

			$key = 'Category';
			if($categoryOption){
				$key = $key . ' ' . $categoryOption;
			}


			$result = DB::select(
					self::$sql,
					[$key, $reportClass]
			);
			return $result;
		}

		/**
		 * Station取得
		 */
		function getStation ($reportClass){
			$result = DB::select(
					self::$sql,
					['Station', $reportClass]
			);
			return $result;
		}

		/**
		 * Line取得
		 */
		function getLine ($reportClass){
			$result = DB::select(
					self::$sql,
					['Line', $reportClass]
			);
			return $result;
		}

		/**
		 * Sub category取得
		 */
		function getSubCategory ($reportClass){
			$result = DB::select(
					self::$sql,
					['Sub Category', $reportClass]
			);
			return $result;
		}

		/**
		 * DLA CODE取得
		 */
		function getDLACode ($reportClass){
			$result = DB::select(
					self::$sql,
					['DLA Code', $reportClass]
			);
			return $result;
		}

		/**
		 * Weather取得
		 */
		function getWeather ($reportClass){
			$result = DB::select(
					self::$sql,
					['Weather', $reportClass]
			);
			return $result;
		}

		/**
		 * Area取得
		 */
		function getArea ($reportClass){
			$result = DB::select(
					self::$sql,
					['Area', $reportClass]
			);
			return $result;
		}

		/**
		 * Factor取得
		 */
		function getFactor ($reportClass){
			$result = DB::select(
					self::$sql,
					['Factor', $reportClass]
			);
			return $result;
		}

		/**
		 * Influence on Safety取得
		 */
		function getInfluenceOnSafety ($reportClass){
			$result = DB::select(
					self::$sql,
					['Influence on Safety', $reportClass]
			);
			return $result;
		}

		/**
		 * Frequency取得
		 */
		function getFrequency ($reportClass){
			$result = DB::select(
					self::$sql,
					['Frequency', $reportClass]
			);
			return $result;
		}

		/**
		 * Report Status取得
		 */
		function getReportStatus (){
			$result = DB::select(
					self::$sql,
					['Report Status', 0]
			);
			return $result;
		}
	}
}