<?php

return[

	// ldap認証
	'ldap_host_1'	=> 	'10.1.144.11',
	'ldap_port_1'	=>	'389',
	'ldap_host_2'	=> 	'10.1.144.12',
	'ldap_port_2'	=>	'389',
	'ldap_server_count'	=>	2,
	'ldap_domain'	=>	'apj\\',

	// 送信元メール
	'from_emal' => 'chirp@flypeach.com',
 	'from_emal_name' => 'Chirp',


	// トップ画面の最新レポート表示部
	'topViews'	=>	[
		'PEACOCK' 	=>	'parts.top.new_report_peacock',
		'PENGUIN' 	=>	'parts.top.new_report_penguin',
		'PEREGRINE' =>	'parts.top.new_report_peregrine'
	],

	// レポート画面の個別部
	'reportViews'	=>	[
		'1'	=>	'parts.report.report_penguin',
		'2'	=>	'parts.report.report_peregrine',
		'3'	=>	'parts.report.report_peregrine',
		'4'	=>	'parts.report.report_peacock'
	],

	// プレビュー画面の個別部
	'previewViews'	=>	[
		'1'	=>	'parts.preview.preview_penguin',
		'2'	=>	'parts.preview.preview_peregrine',
		'3'	=>	'parts.preview.preview_peregrine',
		'4'	=>	'parts.preview.preview_peacock'
	],

	// トップ画面コントローラ
	'topControllers' => [
		'PEACOCK'	=> 'TopControllerPEACOCK',
		'PENGUIN'	=> 'TopControllerPENGUIN',
		'PEREGRINE' => 'TopControllerPEREGRINE'
	],

	// レポート画面コントローラ
	'reportControllers' => [
		'PEACOCK'	=> 'ReportControllerPEACOCK',
		'PENGUIN'	=> 'ReportControllerPENGUIN',
		'PEREGRINE' => 'ReportControllerPEREGRINE'
	],

	// プレビュー画面コントローラ
	'previewControllers' => [
		'PEACOCK'	=> 'PreviewControllerPEACOCK',
		'PENGUIN'	=> 'PreviewControllerPENGUIN',
		'PEREGRINE' => 'PreviewControllerPEREGRINE'
	],

	// レポート種別
	'REPORT_CLASS_LIST'	=> [
		'PENGUIN'	=>	[
				['code' => 1, 'value' => 'New Item']
		],
		'PEREGRINE'	=>	[
				['code' => 2, 'value' => 'New Item'],
				['code' => 3, 'value' => 'New Item']
		],
		'PEACOCK'	=>	[
				['code' => 4, 'value' => 'New Item']
		]
	],

	// レポート種別
	'REPORT_CLASS'	=> [
			'PENGUIN'	=> 1,
			'PEREGRINE_Incident' => 3,
			'PEREGRINE_Irregularity' => 2,
			'PEACOCK'	=> 4,
	],

	// レポート種別名
	'REPORT_CLASS_NAME'	=> [
				1	=> 'PENGUIN',
				3 	=> 'PEREGRINE_Incident',
				2 	=> 'PEREGRINE_Irregularity',
				4	=> 'PEACOCK',
	],
	// レポート種別名
	'REPORT_CLASS_BASIC_NAME'	=> [
			1	=> 'PENGUIN',
			2 	=> 'PEREGRINE',
			3 	=> 'PEREGRINE',
			4	=> 'PEACOCK',
	],
	// レポートコード名
	'REPORT_CLASS_BASIC_CODE'	=> [
			'PENGUIN'	=> 1,
			'PEREGRINE' 	=> 2,
			'PEREGRINE' 	=> 3,
			'PEACOCK'	=> 4,
	],

	// レポートステータス
	'REPORT_STATUS'	=> [
			'CREATED'	=> 0,
			'SUBMITTED' => 1,
			'CONFIRMED' => 2,
			'CLOSE'	=> 3,
			'PASSBACK_SUBMITTED'	=> 4,
			'RESUBMIT'	=> 5,
			'PASSBACK_CONFIRMED'	=> 6,
			'RECONFIRM'	=> 7
	],

	// 照会ステータス
	'INQUIRY_STATUS'	=> [
		'INQUIRY'	=> 1,
		'ANSWER' => 2,
		'ANSWER_READ' => 3,
	],

	// 変更画面判定
	'EDIT_MODE_OF_STATUS'	=>	[
		0	=>	'edit',
		1	=>	'confirm',
		2	=>	'close',
		3	=>	'edit',
		4	=>	'edit',
		5	=>	'confirm',
		6	=>	'confirm',
		7	=>	'close'
	],

	// ユーザー権限
	'USER_ROLE'	=>	[
		'REPORTER'	=>	0,
		'MANAGER'	=>	1,
		'APPROVER'	=>	2,
		'ALL'		=>	99
	],

	// メール区分
	'MAIL_KBN' => [
		'Submit'	=>	1,
		'Confirm'	=>	2,
		'Close'	=>	3,
		'Passback'	=>	4,
		'InquirySave'	=>	5,
		'AnswerToInquiry'	=>	6,
		'AlertCreated'		=>	7,
		'AlertUpdated'		=>	8,
	],
	'REPORT_MODE_NAME' => [
		'reference'	=>	'レポート参照画面',
		'edit'		=>	'レポート変更画面',
		'confirm'	=>	'レポート確認画面',
		'close'		=>	'レポート承認画面',
		'inquiry'	=>	'レポート照会画面',
		'answer'	=>	'レポート回答画面',
		'other'		=>	'レポート参照(他部門)画面',
		'relation'	=>	'レポート参照(関連)画面'
	],
	'ALERT_MAIL_TIMING' => [
		'CREATED'				=> 1,
		'CREATED_AND_UPDATED'	=> 2
	]
];