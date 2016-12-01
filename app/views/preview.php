
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="ja" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Chirp <?=HTML::entities($header_title)?></title>
	<link media="all" type="text/css" rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/css/jquery-ui.min.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/css/awesome-bootstrap-checkbox.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/bower_components/Font-Awesome/css/font-awesome.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/css/pnotify.custom.min.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/css/extends-bootstrap.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/css/common.css">
	<link media="all" type="text/css" rel="stylesheet" href="resources/css/style.css">
	<script src="resources/js/jquery-1.11.2.min.js"></script>
	<script src="resources/js/jquery-ui.min.js"></script>
	<script src="resources/bootstrap/js/bootstrap.min.js"></script>
	<script src="resources/js/bootbox.js"></script>
	<script src="resources/js/jquery.blockUI.js"></script>
	<script src="resources/js/pnotify.custom.min.js"></script>
	<script src="resources/js/common.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
	<style>
		#print_title {
			color: #999999;
			font-size: 24px;
			padding: 10px 0 0 180px;
			text-align: left;
		}
		.preview_header {
			width: 30%;
		}
		.preview_header_al {
			font-weight: bold;
		}
		.preview_data {
			width: 70%;
			vertical-align: middle !important;
		}
	</style>


	<script>
	</script>
</head>
<body>

	<div style="text-align: center; width: 800px; margin: auto;">
		<div style="height: 60px; margin-top: 10px;">
			<img src="resources/css/images/peach-logo.png" style="float: left;"><h2 id="print_title">Chirp <?=HTML::entities($report_title)?></h2>
		</div>

		<?php if(count($error_message_list)): ?>

<div class="row">
	<div class="col-md-12" style="margin-bottom: 100px;">
		<?php if(count($error_message_list) > 0){ ?>
		<div class="alert alert-danger">
			<button class="close" data-dismiss="alert">&#215;</button>
			<ul>
			<?php foreach($error_message_list as $message) { ?>
				<li>
					<?php echo $message ?>
				</li>
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
	</div>
</div>
		<?php else: ?>

		<?=$parts_preview ?>

		<?php endif; ?>

		<div class="col-md-10">
			<div class="form-group">
				<button type="button" class="btn btn-lgray col-md-offset-1" onclick="window.close();">&nbsp;Close&nbsp;</button>
				<?php if(count($error_message_list) == 0): ?><button type="button" class="btn btn-lgray col-md-offset-1" onclick="print();">&nbsp;Print&nbsp;</button><?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>
