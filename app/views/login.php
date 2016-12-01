<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="ja" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Chirp - Login</title>
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
</head>

<!-- ログイン画面 -->

<body>

	<?= $parts_common_header ?>

	<div class="container-fluid">
		<form id="loginForm" action="/login/login" method="post" style="margin-top: 40px;">

			<?= $parts_common_error ?>

			<div class="row">
				<div class="form-group col-md-10 col-md-offset-2">
					<label for="login_id" class="col-md-3 control-label text-right">User Name</label>
					<div class="col col-md-4">
						<input type="text" name="login_id" id="login_id" class="form-control" maxlength="8">
					</div>
				</div>
				<div class="form-group col-md-10 col-md-offset-2">
					<label for="password" class="col-md-3 control-label text-right">Password</label>
					<div class="col col-md-4">
						<input type="password" name="password" id="password" class="form-control">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<button id="loginButton" type="submit" class="btn navbar-btn btn-pink">Log in</button>
				</div>
			</div>
		</form>
	</div><!-- container -->
</body>
</html>