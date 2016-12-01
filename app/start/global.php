<?php

/*
|--------------------------------------------------------------------------
| Laravelクラスローダーの登録
|--------------------------------------------------------------------------
|
| Composerを使用することに加え、コントローラーとモデルをロードするために
| Laravelのクラスローダーを使用することもできます。Composerを更新しなくても
| 「グローバル」な名前空間にあなたのクラスを設置しておくのに便利です。
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/extentions',

));

/*
|--------------------------------------------------------------------------
| アプリケーションエラーログ
|--------------------------------------------------------------------------
|
| 素晴らしいMonologライブラリーの上に構築されたアプリケーションのために
| ここではエラーログの設定を行なっています。デフォルトでは、一つの
| 基本的なログファイルを作成し、使用します。
|
*/

Log::useFiles('/home/chirp-admin/chirplogs/laravel.log', 'error');
// Log::useDailyFiles(storage_path() . '/logs/laravel.log', 30, 'debug');

/*
|--------------------------------------------------------------------------
| アプリケーションエラーハンドラー
|--------------------------------------------------------------------------
|
| ここではアプリケーションでエラーが発生した場合の、エラーの処理（ログしたり、
| カスタムビューで特定のエラーを表示したりするなどを含む）を定義します。
| 異なったタイプの例外を処理するために多くのエラーハンドラーを登録することも
| できます。もし、何もリターンしなれば、デフォルトのエラービューが表示され、
| それにはデバッグ中であれば詳細なスタックトレースも含まれます。
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception . "\nurl=" . Request::url());
// 	Log::info(Request::url());

	return Response::View('error');
});

/*
|--------------------------------------------------------------------------
| メンテナンスモードハンドラー
|--------------------------------------------------------------------------
|
| Artisanコマンドの"down"でメンテナンスモードにすることができます。
| このアプリケーションにふさわしいメンテナンスモードでの
| 表示をここで定義してください。
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

DB::listen(function($sql, $bindings, $time)
{
	Log::info($sql);
});

/*
|--------------------------------------------------------------------------
| フィルターファイルの読み込み
|--------------------------------------------------------------------------
|
| 以下でアプリケーションのフィルターファイルを読み込んでいます。
| これによりルートとフィルターを同じルーティングファイルに押しこまずに
| 分けて保存できるようになりました。
|
*/

require app_path().'/filters.php';

// サービスプロバイダ登録
App::register('CommonServiceProvider');