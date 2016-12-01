<?php

use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider {

	public function register() {

		// AD認証
		$this->app->bindShared('LdapAuth', function() {return new CommonGateway\LdapAuth;});

		// DBアクセス
		$this->app->bindShared('DataManager', function() {return new CommonGateway\DataManager;});

		// メール送信
		$this->app->bindShared('MailManager', function() {return new CommonGateway\MailManager;});

		// システムコード
		$this->app->bindShared('SystemCodeManager', function() {return new CommonGateway\SystemCodeManager;});

		// 共通チェック
		$this->app->bindShared('CommonCheckLogic', function() {return new CommonGateway\CommonCheckLogic;});

		// 日付ユーティリティ
		$this->app->bindShared('DateUtil', function() {return new CommonGateway\DateUtil;});
	}

}
