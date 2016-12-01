<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="ja" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Chirp - ERROR</title>
	<?= HTML::style('resources/bootstrap/css/bootstrap.min.css') ?>
    <?= HTML::style('resources/css/jquery-ui.min.css') ?>
    <?= HTML::style('resources/css/awesome-bootstrap-checkbox.css') ?>
    <?= HTML::style('resources/bower_components/Font-Awesome/css/font-awesome.css') ?>
    <?= HTML::style('resources/css/pnotify.custom.min.css') ?>
    <?= HTML::style('resources/css/extends-bootstrap.css') ?>
    <?= HTML::style('resources/css/common.css') ?>
    <?= HTML::style('resources/css/style.css') ?>
    <?= HTML::script('resources/js/jquery-1.11.2.min.js') ?>
    <?= HTML::script('resources/js/jquery-ui.min.js') ?>
    <?= HTML::script('resources/bootstrap/js/bootstrap.min.js') ?>
  	<?= HTML::script('resources/js/bootbox.js') ?>
  	<?= HTML::script('resources/js/jquery.blockUI.js') ?>
  	<?= HTML::script('resources/js/pnotify.custom.min.js') ?>
  	<?= HTML::script('resources/js/common.js') ?>
  	<script type="text/javascript">
  	disableBrowserBack();
  	</script>
</head>
<body>
	<nav class="navbar navbar-peach">
		<div class="container-fluid">
			<div id="main">
				<p id="logo"></p>
				<h1>Chirp</h1>
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="title">エラーが発生しました。</div>
		<div class="message">
			<p><a href="/p/chirp">ログインページ</a>から、やり直してください。</p>
		</div>
	</div>
</body>
</html>
