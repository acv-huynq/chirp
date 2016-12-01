<?php

namespace CommonGateway {



	use Log;
	use Config;
	use Exception;

	/**
	 * LDAP認証クラス.
	 * php.ini の php_ldap.dll のコメントアウトを解除すること
	 * C:\xampp\php\libsasl.ddlをC:\xampp\apache\binに配置
	 */
	class LdapAuth {


		private $ldapconn;


		/**
		 * コンストラクタ
		 */
		function __construct() {
			Log::info("LdapAuth new");
		}

		/**
		 * LDAP認証
		 * @param string $user ユーザーID
		 * @param string $pass パスワード
		 * @return boolean 認証結果
		 */
		public function auth($user, $pass) {

			$result = false;

			for($i = 1 ; $i <= Config::get('const.ldap_server_count'); $i++){

				try{

					$host = Config::get('const.ldap_host_' . $i);
					$port = Config::get('const.ldap_port_' . $i);

					// LDAP接続
					$this->ldapconn = ldap_connect($host, $port);

					if($this->ldapconn){

						ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
						ldap_set_option ($this->ldapconn, LDAP_OPT_REFERRALS, 0);
						ldap_set_option($this->ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 5);

						// バインド
						$ldapbind = ldap_bind($this->ldapconn, Config::get('const.ldap_domain') . $user, $pass);

						// バインド解除
						ldap_unbind($this->ldapconn);

						$result = true;
						break;
					}

				}catch(Exception $e){
					// nop
				}

				try{
					// 切断
					if($this->ldapconn){
						ldap_close($this->ldapconn);
					}

				}catch(Exception $e){
					// nop
				}

			}
			return $result;
		}

	}
}