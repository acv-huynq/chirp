<?php

namespace CommonGateway {

	use DB;
	use Mail;
	use Config;
	use Log;
	use Swift_Mailer;
	use Swift_SmtpTransport;
	use Swift_Message;
	use Exception;

	class MailManager {

		/**
		 * コンストラクタ
		 */
		function __construct() {

		}

		/**
		 * メール送信
		 * @param $report_no
		 * @param $report_name
		 * @param $user_role
		 * @param $mail_kbn
		 * @param $replace_array [key,value](keyをvalueへ置換)
		 * @return boolean
		 */
		function send($report_no, $report_name, $user_role, $mail_kbn, $replace_array){
			// レポート情報取得
			$sqlString =
			'SELECT t1.email, t2.title, t2.body '
			.'FROM mst_mail_manage t1  '
			.'inner join mst_mail_contents t2  '
			.'on t1.report_name = t2.report_name and t1.user_role = t2.user_role  '
			.'WHERE t1.report_name = ? and t1.user_role = ? and t2.mail_kbn = ? ';
			$result = DB::selectOne(
					$sqlString,
					[Config::get('const.REPORT_CLASS_BASIC_NAME')[$report_name], $user_role, $mail_kbn]
			);

			if($result == null){
				return false;
			}

			// 送信元メールアドレス
			$mail_from = Config::get('const.from_emal');
			$mail_from_name = Config::get('const.from_emal_name');

			// 送信先メールアドレス
			$mail_to = $result->email;

			// 起票者宛の場合はメール送信先をユーザー情報から取得
			if ($user_role == Config::get('const.USER_ROLE.REPORTER')) {
				// レポート情報取得
				$sqlString =
				'SELECT t2.email as rep_email '
						.'FROM report_basic_info t1 '
						.'inner join mst_user_info t2 '
						.'on t1.create_user_id = t2.login_id '
						.'WHERE t1.report_no = ?';
				$result2 = DB::selectOne(
						$sqlString,
						[$report_no]
				);

				if($result2 == null){
					return false;
				}

				$mail_to = $result2->rep_email ;
			}

			$mail_to_name = '';//名称未定

			// タイトル・本文の文字置換
			$mail_title = $result->title;
			$mail_body = $result->body;
			foreach($replace_array as $key => $value){
				$pattern = '/'.$key.'/';
				$replacement = $value;
				$mail_title =  preg_replace($pattern, $replacement, $mail_title);
				$mail_body = preg_replace($pattern, $replacement, $mail_body);
			}

			// メール内容
			$mail_content =
			[
				'mail_from' => $mail_from,
				'mail_from_name' => $mail_from_name,
				'mail_to' => explode(',',$mail_to),
// 				'mail_to' => "$mail_to",
				'mail_to_name' => $mail_to_name,
				'mail_subject' => $mail_title,
			];

			try{
				// メール送信
				$send_result = Mail::send(
						['text' => 'emails.empty'],
						['mail_body' => $mail_body],
						function($e) use ($mail_content)  {
							$e->to($mail_content['mail_to'])
							// 					$e->to($mail_content['mail_to'], $mail_content['mail_to_name'])
							->from($mail_content['mail_from'], $mail_content['mail_from_name'])
							->subject($mail_content['mail_subject']);
						}
				);

			}catch(Exception $e){
				// サーバ接続エラー時（予備サーバへ再送信）
				$send_result = $this->reserveSend($mail_content, $mail_body);
			}
			return $send_result;
		}

		/**
		 * メール送信（予備）
		 * @param unknown $mail_content
		 * @param unknown $mail_body
		 */
		function reserveSend($mail_content, $mail_body, $address_method = 'setTo'){
			// メール設定
			// 			$transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587, 'tls')
			$transport = Swift_SmtpTransport::newInstance(Config::get('mail2.host'), Config::get('mail2.port'), Config::get('mail2.encryption'))
			->setUsername(Config::get('mail2.username'))
			->setPassword(Config::get('mail2.password'));
			$mailer = Swift_Mailer::newInstance($transport);

			// メッセージ作成
			$message = Swift_Message::newInstance()
			->setSubject($mail_content['mail_subject'])
			->$address_method($mail_content['mail_to'])
			->setFrom($mail_content['mail_from'], $mail_content['mail_from_name'])
			->setBody($mail_body);

			// メール送信
// 			$message->toString();
			$send_result = $mailer->send($message);

		}

		/**
		 * アラートメール送信
		 * @param unknown $user_list
		 * @param unknown $report_name
		 * @param unknown $mail_kbn
		 */
		function alertMail($user_list, $mail_kbn, $replace_array) {

			// 宛先メールアドレス取得
			$user_result = DB::table('mst_user_info')
			->distinct()
			->select(['report_name', 'email'])
			->whereIn('login_id', $user_list)
			->get();

			$mail_group = array();
			foreach($user_result as $user) {
				$mail_group[$user->report_name][] = $user->email;
			}

			// 送信先の部署ことにメールを送信
			foreach($mail_group as $report_name => $mail_to) {
				// メールの内容を取得
				$mail_content_result = DB::table('mst_mail_contents')
				->select(['title', 'body'])
				->where('report_name', $report_name)
				->where('mail_kbn', $mail_kbn)
				->where('user_role', Config::get('const.USER_ROLE.ALL'))
				->first();

				// タイトル・本文の文字置換
				$mail_title = $mail_content_result->title;
				$mail_body = $mail_content_result->body;
				foreach($replace_array as $key => $value){
					$pattern = '/'.$key.'/';
					$replacement = $value;
					$mail_title =  preg_replace($pattern, $replacement, $mail_title);
					$mail_body = preg_replace($pattern, $replacement, $mail_body);
				}

				// 送信元メールアドレス
				$mail_from = Config::get('const.from_emal');
				$mail_from_name = Config::get('const.from_emal_name');

				// メール内容
				$mail_content =
				[
						'mail_from' => $mail_from,
						'mail_from_name' => $mail_from_name,
						'mail_to' => $mail_to,
						'mail_subject' => $mail_title,
				];

				try{
					// メール送信
					$send_result = Mail::send(
							['text' => 'emails.empty'],
							['mail_body' => $mail_body],
							function($e) use ($mail_content)  {
								$e->bcc($mail_content['mail_to'])
								->from($mail_content['mail_from'], $mail_content['mail_from_name'])
								->subject($mail_content['mail_subject']);
							}
					);

				}catch(Exception $e){
					// サーバ接続エラー時（予備サーバへ再送信）
					$send_result = $this->reserveSend($mail_content, $mail_body, 'setBcc');
				}

			}
			return $send_result;

		}

	}
}