<?php

/*
|--------------------------------------------------------------------------
| アプリケーションの生成
|--------------------------------------------------------------------------
|
| 最初に行うのは、Laravelの全コンポーネントに対し「糊」のように働き、
| いろいろな部分をシステムのため全部結びつけるIoCコンテナとしても
| 動作するLaravelアプリケーションのインスタンスを生成することです。
|
*/

// $app = new Illuminate\Foundation\Application;
class MyApplication extends Illuminate\Foundation\Application
{

	public function run(\Symfony\Component\HttpFoundation\Request $request = null)
	{
		$request = $request ?: $this['request'];

//		$response;
		try{
			$response = with($stack = $this->getStackedClient())->handle($request);

		}catch(Exception $exception){

			Log::useFiles('/home/chirp-admin/chirplogs/laravel.log');
			Log::error($exception);
			return Response::View('error');
		}

		$response->send();

		$stack->terminate($request, $response);
	}
}

$app = new MyApplication;

/*
|--------------------------------------------------------------------------
| アプリケーション動作環境の決定
|--------------------------------------------------------------------------
|
| Laravelは極めて簡単なアプローチをアプリケーション環境に対して取っています。
| 設定したい環境に対応するマシン名を指定してください。
| それにより、自動的に環境は決定されます。
|
*/

$env = $app->detectEnvironment(array(

	'local'      => array('local.*', '*.local', '*.lan', '61-*' ),

));

/*
|--------------------------------------------------------------------------
| パスの結合
|--------------------------------------------------------------------------
|
| ここではpaths.phpで設定されているパスをappと結合しています。
| これは変更しないでください。変更の必要がある場合は、
| pahts.phpファイルを開き内部の設定を変更してください。
|
*/

$app->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| アプリケーションをロードする
|--------------------------------------------------------------------------
|
| ここでこのIlluminateアプリケーションをロードしています。
| 与えられたリクエストのために実際に実行されるアプリケーションとは
| 独立させてアプリケーションを生成できるように、別の場所に分けています。
|
*/

$framework = $app['path.base'].
                 '/vendor/laravel/framework/src';

require $framework.'/Illuminate/Foundation/start.php';

/*
|--------------------------------------------------------------------------
| アプリケーションをリターンする
|--------------------------------------------------------------------------
|
| このスクリプトはアプリケーションのインスタンスを返します。インスタンスは
| 呼び出し元のスクリプトに渡されます。ですから実際に動作している
| アプリケーションとレスポンスの送信のインスタンスを分けて構築できます。
|
*/

return $app;
