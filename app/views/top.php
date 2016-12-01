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
   	<?= HTML::style('resources/css/dataTables.bootstrap.css') ?>
    <?= HTML::style('resources/css/awesome-bootstrap-checkbox.css') ?>
    <?= HTML::style('resources/bower_components/Font-Awesome/css/font-awesome.css') ?>
    <?= HTML::style('resources/css/extends-bootstrap.css') ?>
    <?= HTML::style('resources/css/common.css') ?>
    <?= HTML::style('resources/css/style.css') ?>

    <?= HTML::script('resources/js/jquery-1.11.2.min.js') ?>
    <?= HTML::script('resources/js/jquery-ui.min.js') ?>
    <?= HTML::script('resources/bootstrap/js/bootstrap.min.js') ?>
  	<?= HTML::script('resources/js/bootbox.js') ?>
  	<?= HTML::script('resources/js/jquery.blockUI.js') ?>
  	<?= HTML::script('resources/js/jquery.dataTables.min.js') ?>
  	<?= HTML::script('resources/js/dataTables.bootstrap.js') ?>
  	<?= HTML::script('resources/js/common.js') ?>
  	<?= HTML::script('resources/js/jquery.narrows.min.js') ?>
  	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

 	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
	<script type="text/javascript">

	disableBrowserBack();

	settingTable('#inqueryReportTable',1000,false, false, false);
	settingTable('#newReportTable',6, true, true, true);
	settingTable('#newReportTable2',6, true, true, true);
	settingTable('#searchReportTable',10, false, true, true);

	$(function(){

		$(".datepicker").datepicker();

		if($('#_mode').val() == 'search_success'){
			var position = $("#reportSearch").offset().top;
			$(window).scrollTop(position);
		}

		var first_flg = true;
		$('#search_report_class').change(function() {
			var report_class = $(this).val();

			/** カテゴリ初期化 **/
			if(first_flg == false) {
				$('#search_category').val('');
			}

			/** レポート種別による設定 **/
			if(report_class == '2' || report_class == '3') {
				$('#search_area').prop('disabled', false);
				$('#search_assessment').prop('disabled', false);
			} else {
				$('#search_area').val('');
				$('#search_area').prop('disabled', true);
				$('#search_assessment').val('');
				$('#search_assessment').prop('disabled', true);
			}

			if(report_class == '4') {
				$('#search_station').val('');
				$('#search_station').prop('disabled', true);
			} else {
				$('#search_station').prop('disabled', false);
			}

			first_flg = false;

		});

		$('#search_report_class').change();

		$("#search_report_class").narrows("#search_category");

	});


	function addReport(formObj, action, report_class){

		$('#_selected_report_class').val(report_class);
		$('#_selected_report_status').val('');
		$('#_selected_report_no').val('');
		$('button').prop("disabled", true);
		$('tr').addClass("avoid-clicks");
		$(formObj).attr('action', action);
		$(formObj).submit();
	}

	function selectInquiryReport(formObj, action, report_class, report_no, report_status){

		$('#_selected_report_class').val(report_class);
		$('#_selected_report_status').val(report_status);
		$('#_selected_report_no').val(report_no);
		$('#_inquiry_mode').val('on');
		$('tr').addClass("avoid-clicks");
		$('button').prop("disabled", true);
		$(formObj).attr('action', action);
		$(formObj).submit();
	}

	function selectReport(formObj, action, report_class, report_no, report_status){

		$('#_selected_report_class').val(report_class);
		$('#_selected_report_status').val(report_status);
		$('#_selected_report_no').val(report_no);
		$('#_inquiry_mode').val('off');
		$('button').prop("disabled", true);
		$('tr').addClass("avoid-clicks");
		$(formObj).attr('action', action);
		$(formObj).submit();
	}

	function selectPreview(formObj, action, report_class, report_no, report_status) {

		$('#_selected_report_class').val(report_class);
		$('#_selected_report_status').val(report_status);
		$('#_selected_report_no').val(report_no);
		$(formObj).attr('action', action);
		$(formObj).attr('target', 'preview');
		$(formObj).submit();
		$(formObj).removeAttr('target');

	}

	function alertSetting(formObj, href) {

		$('button').prop("disabled", true);
		$('tr').addClass("avoid-clicks");
		$(formObj).attr('action', href);
		$(formObj).submit();
	}
	</script>

 </head>

<body>

	<?= $parts_common_header ?>

	<div class="container-fluid">
		<form id="mainForm" action="" method="post">
			<input type="hidden" id="_mode" name="_mode" value="<?php echo $_mode ?>" />
			<input type="hidden" id="_selected_report_no" name="_selected_report_no" value="" />
			<input type="hidden" id="_selected_report_class" name="_selected_report_class" value="" />
			<input type="hidden" id="_selected_report_status" name="_selected_report_status" value="" />
			<input type="hidden" id="_inquiry_mode" name="_inquiry_mode" value="" />

			<?= $parts_common_error ?>

			<?php if(unserialize(Session::get('SESSION_KEY_CHIRP_USER'))->userInfo->report_name == 'PEREGRINE' &&
					!unserialize(Session::get('SESSION_KEY_CHIRP_USER'))->isCreator()): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group pull-right">
						<button type="button" class="btn btn-pink btn-xs" onclick="addReport(document.forms.mainForm, '/p/chirp/top/alert')">&nbsp;Alert Setting&nbsp;</button>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php if(unserialize(Session::get('SESSION_KEY_CHIRP_USER'))->userInfo->user_role != 0 ){?>
			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-1 pull-left">
							<span style="background-color: #CE019E;font-size:150%">&nbsp;</span>
						</div>
						<div class="col-md-10 text-left">
							<span style="font-size:150%"><strong>Inquiry</strong></span>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-margin-bottom-80">
				<div class="col-md-12">
					<table id="inqueryReportTable" class="table table-bordered table-hover" border="1" cellpadding="2"  bordercolor="#000000">
						<thead>
							<tr class="gray">
								<th>Date</th>
								<th>Report No</th>
								<th>Reported By</th>
								<th>Inquired From</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach($inquiry_report_list as $data) { ?>
							<tr onclick="selectInquiryReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')">
								<td><?= HTML::entities($data->inquiry_timestamp) ?></td>
								<td><?= HTML::entities($data->report_no) ?></td>
								<td><?= HTML::entities($data->reported_by) ?></td>
								<td><?= HTML::entities($data->inquery_from) ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php } ?>

			<?= $new_report_view ?>

			<div id="reportSearch" class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-1 pull-left">
							<span style="background-color: #CE019E;font-size:150%">&nbsp;</span>
						</div>
						<div class="col-md-10 text-left">
							<span style="font-size:150%"><strong>Search</strong></span>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top: 10px;">
				<div class="col-md-4">
         			<?= Form::text('search_free_word', Input::old('search_free_word', $search_report_condition->free_word), ['id' => 'search_free_word', 'class' => 'form-control input-sm', 'placeholder' => 'Keywords（including Report No,Flight No or Contents）']) ?>
				</div>
				<div class="col-md-3">
					<select id="search_report_class" name="search_report_class" class="form-control">
						<?php foreach($report_class_list as $data) { ?>
							<option value="<?= HTML::entities($data->code2) ?>" <?php echo Input::old('search_report_class', $search_report_condition->report_class) == $data->code2 ?  'selected="selected"' : '' ?> <?= HTML::entities($data->disable) ?>><?= HTML::entities($data->value2) ?></option>
						<?php } ?>
					</select>
				</div>
			</div>


			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<label class="col-md-12 control-label text-left">Created Date</label>
					</div>
					<div class="row">
						<div class="col-md-5">
         					<?= Form::text('search_create_date_from', Input::old('search_create_date_from', $search_report_condition->create_date_from), ['id' => 'search_create_date_from', 'class' => 'form-control datepicker', 'placeholder' => 'From Date','maxlength' => '10']) ?>
						</div>
						<div class="col-md-1">
							<font size="+2.5">-</font>
						</div>
						<div class="col-md-5">
         					<?= Form::text('search_create_date_to', Input::old('search_create_date_to', $search_report_condition->create_date_to), ['id' => 'search_create_date_to', 'class' => 'form-control datepicker', 'placeholder' => 'To Date','maxlength' => '10']) ?>
						</div>
					</div>
				</div>


				<div class="col-md-4">
					<div class="row">
						<label class="col-md-12 control-label text-left">Reporting Date</label>
					</div>
					<div class="row">
						<div class="col-md-5">
							<?= Form::text('search_reporting_date_from', Input::old('search_reporting_date_from', $search_report_condition->reporting_date_from), ['id' => 'search_reporting_date_from', 'class' => 'form-control datepicker', 'placeholder' => 'From Date','maxlength' => '10']) ?>
						</div>
						<div class="col-md-1">
							<font size="+2.5">-</font>
						</div>
						<div class="col-md-5">
							<?= Form::text('search_reporting_date_to', Input::old('search_reporting_date_to', $search_report_condition->reporting_date_to), ['id' => 'search_reporting_date_to', 'class' => 'form-control datepicker', 'placeholder' => 'To Date','maxlength' => '10']) ?>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="row">
						<label class="col-md-12 control-label text-left">Flight Date</label>
					</div>
					<div class="row">
						<div class="col-md-5">
							<?= Form::text('search_flight_date_from', Input::old('search_flight_date_from', $search_report_condition->flight_date_from), ['id' => 'search_flight_date_from', 'class' => 'form-control datepicker', 'placeholder' => 'From Date','maxlength' => '10']) ?>
						</div>
						<div class="col-md-1">
							<font size="+2.5">-</font>
						</div>
						<div class="col-md-5">
							<?= Form::text('search_flight_date_to', Input::old('search_flight_date_to', $search_report_condition->flight_date_to), ['id' => 'search_flight_date_to', 'class' => 'form-control datepicker', 'placeholder' => 'To Date','maxlength' => '10']) ?>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row">
						<label class="col-md-2 control-label text-left">Report Status</label>
						<label class="col-md-2 control-label text-left">Category</label>
						<label class="col-md-2 control-label text-left">Station</label>
						<label class="col-md-2 control-label text-left">Area</label>
						<label class="col-md-2 control-label text-left">Assessment</label>
					</div>
					<div class="row">
						<div class="col-md-2">
							<select id="search_status" name="search_status" class="form-control" >
								<option class="additional-conditions" value=""></option>
								<?php foreach($report_status_list as $report_status):?>
								<option class="additional-conditions" <?php echo Input::old('search_status', $search_report_condition->status) == $report_status->code2 ?  'selected="selected"' : '' ?> value="<?= HTML::entities($report_status->code2)?>" ><?= HTML::entities($report_status->value2) ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2">
							<select id="search_category" name="search_category" class="form-control" >
								<option class="additional-conditions" value="" data-report-class="0"></option>
								<?php foreach($category_list as $report_class => $data): ?>
								<?php foreach($data as $category): ?>
								<?php if($report_class != '4'): ?>
								<option class="additional-conditions" value="<?=$category->code2?>" <?php echo Input::old('search_category', $search_report_condition->category) == $category->code2 ?  'selected="selected"' : '' ?> data-search_report_class="<?=$report_class?>"><?=HTML::entities($category->value2)?></option>
								<?php else: ?>
								<option class="additional-conditions" value="<?=$category->code2?>" <?php echo Input::old('search_category', $search_report_condition->category) == $category->code2 ?  'selected="selected"' : '' ?> data-search_report_class="<?=$report_class?>"><?=HTML::entities($category->code2)?> <?=$category->value2?></option>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2">
							<input id="search_station" class="form-control additional-conditions" name="search_station" type="text" placeholder="ex. KIX CTS" value="<?=$search_report_condition->station ?>">
						</div>
						<div class="col-md-2">
							<select id="search_area" name="search_area" class="form-control" >
								<option class="additional-conditions" value=""></option>
								<?php foreach($area_list as $area): ?>
								<option class="additional-conditions" <?php echo Input::old('search_area', $search_report_condition->area) == $area->code2 ?  'selected="selected"' : '' ?> value="<?=HTML::entities($area->code2) ?>" ><?=HTML::entities($area->value2) ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2">
							<select id="search_assessment" name="search_assessment" class="form-control " >
								<option class="additional-conditions" value=""></option>
								<option class="additional-conditions" <?php echo Input::old('search_assessment', $search_report_condition->assessment) == 'Level A' ?  'selected="selected"' : '' ?> value="Level A" >Level A</option>
								<option class="additional-conditions" <?php echo Input::old('search_assessment', $search_report_condition->assessment) == 'Level B' ?  'selected="selected"' : '' ?> value="Level B" >Level B</option>
								<option class="additional-conditions" <?php echo Input::old('search_assessment', $search_report_condition->assessment) == 'Level C' ?  'selected="selected"' : '' ?> value="Level C" >Level C</option>
								<option class="additional-conditions" <?php echo Input::old('search_assessment', $search_report_condition->assessment) == 'Level D' ?  'selected="selected"' : '' ?> value="Level D" >Level D</option>
							</select>
						</div>
					</div>

					<div class="row">
						<label class="col-md-12 control-label text-left">PAX Information</label>
					</div>
					<div class="row">
						<div class="col-md-2">
							<input id="search_first_name" class="form-control additional-conditions" placeholder="First Name" maxlength="40" name="search_first_name" type="text" value="<?=$search_report_condition->first_name ?>">
						</div>
						<div class="col-md-2">
							<input id="search_last_name" class="form-control additional-conditions" placeholder="Last Name" maxlength="40" name="search_last_name" type="text" value="<?=$search_report_condition->last_name ?>">
						</div>
						<div class="col-md-2">
							<input id="search_record_locator" class="form-control additional-conditions" placeholder="PNR" maxlength="7" name="search_record_locator" type="text" value="<?=$search_report_condition->record_locator ?>">
						</div>
					</div>
				</div>
				<div class="col-md-12"><h3></h3></div>
				<div class="col-md-12">
					<button type="button" class="btn btn-lgray center-block" onclick="exec(this.form, '/p/chirp/top/search')">&nbsp;&nbsp;Search&nbsp;&nbsp;</button>
				</div>
				<div class="col-md-12"><h2></h2></div>
			</div>
			<div class="row">
				<div class="col-md-12"><p></p></div>
				<div class="col-md-12"><p></p></div>
			</div>

			<div class="row row-margin-bottom-80">
				<div class="col-md-12">
					<table id="searchReportTable" class="table table-bordered table-hover" border="1" cellpadding="2"  bordercolor="#000000">
						<thead>
							<tr class="gray">
								<th>Report Status</th>
								<th>Reporting Date</th>
								<th>Report No</th>
								<th>Report Title</th>
								<th>Flight No</th>
								<th>Inquiry Status</th>
								<th>Preview</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($search_report_list as $data): ?>
							<tr>
							<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><?= HTML::entities($data->report_status_name) ?></td>
							<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><?= HTML::entities($data->reporting_date) ?></td>
							<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><?= HTML::entities($data->report_no) ?></td>
							<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><?= HTML::entities($data->report_title) ?></td>
							<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><?= HTML::entities($data->flight_number) ?></td>
							<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><?= HTML::entities($data->inquiry_status) ?></td>
							<td><button type="button" class="btn btn-lgray center-block btn-xs" onclick="selectPreview(document.forms.mainForm, '/p/chirp/top/preview', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>', '<?= HTML::entities($data->report_status) ?>')"><span id="PreviewIcon" class="glyphicon glyphicon-zoom-in"></span></button></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div><!-- container -->
</body>
</html>