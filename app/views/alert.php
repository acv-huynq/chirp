<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="ja" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Chirp <?= HTML::entities($header_title) ?></title>
	<?= HTML::style('resources/bootstrap/css/bootstrap.min.css') ?>
    <?= HTML::style('resources/css/jquery-ui.min.css') ?>
    <?= HTML::style('resources/css/awesome-bootstrap-checkbox.css') ?>
    <?= HTML::style('resources/bower_components/Font-Awesome/css/font-awesome.css') ?>
    <?= HTML::style('resources/css/pnotify.custom.min.css') ?>
    <?= HTML::style('resources/css/extends-bootstrap.css') ?>
    <?= HTML::style('resources/css/common.css') ?>
    <?= HTML::style('resources/css/style.css') ?>
    <?= HTML::style('resources/css/new_style.css') ?>
    <?= HTML::script('resources/js/jquery-1.11.2.min.js') ?>
    <?= HTML::script('resources/js/jquery-ui.min.js') ?>
    <?= HTML::script('resources/bootstrap/js/bootstrap.min.js') ?>
  	<?= HTML::script('resources/js/bootbox.js') ?>
  	<?= HTML::script('resources/js/jquery.blockUI.js') ?>
  	<?= HTML::script('resources/js/pnotify.custom.min.js') ?>
  	<?= HTML::script('resources/js/common.js') ?>
 	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />

  	<script>

	disableBrowserBack();

	function buttonClick(buttonType) {
		var $_html;
		var $_message;
		var $report_class = $("#_report_class").val();

		switch(buttonType){
			case "cancel":
				$_message = "アラート条件の編集を破棄します。よろしいですか？\n" +
							"Are you sure you want to discard the editing of alert condition?";
				break;
			case "save":
				$_message = "アラート条件を保存します。よろしいですか？\n" +
				 			"Are you sure you want to save the alert condition?";
				break;
			default:
				$_message = "";
		}

		var $confirm = true;

		$_html = "/p/chirp/alert/" + buttonType;

		if ($_message != "") {
			$confirm = confirm($_message);
		}

		if ($confirm) {
			$('#mainForm').attr('action', $_html)
			              .submit();
		}
	}

	$(function(){

		$(window).load(function () {

			$('#formClear').click(function() {
				$('input[type="radio"]').removeAttr('checked');
				$('input[type="checkbox"]').removeAttr('checked');
			});

		});
	});
	</script>

</head>

<!-- アラート設定画面 PEREGRINE -->

<body>

	<?= $parts_common_header ?>

	<div class="container-fluid">
		<form id="mainForm" action="" method="post" enctype="multipart/form-data">


			<!-- エラーメッセージ表示エリア -->
			<?= $parts_common_error ?>

			<div class="form-horizontal">
				<div class="form-group">
					<div class="col-md-2 pull-left text-left">
								<label class="text-left" style="font-size:150%;" ><strong>Alert Condition</strong></label><br><span style="margin-bottom: 5px">通知条件</span>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-xs btn-lgray clear-condition pull-left" id="formClear">Clear</button>
					</div>
				</div>
			</div>
			<div class="alert_area form-horizontal">
				<div class="form-group">
					<div class="col-md-2 text-left">
						<label class="control-label" style="margin-bottom: 5px">Alert on</label><br><span>通知設定</span>
					</div>
					<div class="row col-md-9 text-left">
						<div class="radio" style="margin-left: 15px;">
								<input type="radio" name="timing" value="1" id="created" <?php if(Input::old('timing', $alert_setting['timing']) == '1'): ?>checked="checked"<?php endif; ?>>
								<label for="created">created</label><br><span style="margin-top: 5px;margin-left: 5px">新規作成時</span>
						</div>
						<div class="radio" style="margin-left: 15px;">
								<input type="radio" name="timing" value="2" id="created_and_updated" <?php if(Input::old('timing', $alert_setting['timing']) == '2'): ?>checked="checked"<?php endif; ?>>
								<label for="created_and_updated">created and updated</label><br><span style="margin-top: 5px;margin-left: 5px">新規作成時と更新時</span>
						</div>
					</div>
				</div>
			</div>
			<div id="station_area" class="form-horizontal">
				<div class="form-group">
					<div class="col-md-2 text-left">
						<label class="control-label" style="margin-bottom: 5px">Station</label><br><span>空港名</span>
					</div>
					<div class="row col-md-9 text-left">
						<?php $input_station = (array)Input::old('station', $alert_setting['station']); ?>
						<?php foreach($station_list as $station): ?>
						<div class="col-md-3">
							<div class="checkbox checkbox-inline">
								<input id="station_<?= HTML::entities($station->code2) ?>" name="station[]" type="checkbox" value="<?= HTML::entities($station->code2) ?>" <?php if(in_array($station->code2, $input_station)): ?>checked="checked"<?php endif; ?>>
								<label for="station_<?= HTML::entities($station->code2) ?>"></label>
							</div>
							<?= HTML::entities($station->value2) ?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<div class="row row-margin-top-80">
				<div class="form-group">
					<div class="col-md-1"></div>
					<div class="col-md-10">
					<button type="button" class="btn btn-pink" onclick="buttonClick('cancel')">&nbsp;Cancel&nbsp;</button>
					<button type="button" class="btn btn-pink col-md-offset-1" onclick="buttonClick('save')">&nbsp;&nbsp;Apply&nbsp;&nbsp;</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>