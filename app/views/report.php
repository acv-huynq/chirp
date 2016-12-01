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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
 	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />

	<script>

	disableBrowserBack();

	function loadcategory(){
		// エラー時に前回データ取得不能エリア（category,MR）のデータ回復

			// category
			<?php $category_listSize = Input::old('category_list_count', 0); ?>
			<?php for ($index = 0; $index < $category_listSize; $index++){
				$item_caterory = Input::old("category_".($index + 1), null);
				if($item_caterory  != null){
			?>
				$('#category_<?=($index + 1)?>').prop('checked', true); // ON にする
			<?php
				}else{
			?>
				$('#category_<?=($index + 1)?>').prop('checked', false); // OFF にする
			<?php
				}
			}
			?>

			// MR
			<?php
			$mr_content = Input::old("mr", null);
			if($mr_content  !== null){
			?>
				$('#mr').val('<?=$mr_content?>');
			<?php
			}
			?>
	}

	function clearcategory(){
		$('div#category_area  :checkbox') .prop('checked', false); // OFF にする
		$('#mr') .val(''); // 空欄 にする
	}

	function errorcategory(){
		var err_title = $('#category .container-fluid .title').text();
		var pattern = "エラー";
		if (err_title.match(pattern)) {
		    location.href  = '/p/chirp/error';
		}
	}


	// 追加お客様情報存在チェック
	function checkAdditionalPaxinfo(){
		var addtionData = false;
		$('.additional-pax-info'+':text').each(function(i) {
		    var inputData = $(this).val();
		    if(inputData){
			    // データあり
		    	addtionData = true;
		    }
		});
		$('.additional-pax-info'+':selected').each(function(i) {
		    var inputData = $(this).val();
		    if(inputData){
			    // データあり
		    	addtionData = true;
			}
		});

		// 追加お客様情報あり（表示）
		if(addtionData){
			$('#collapsePaxInfo').collapse('show');
		}

	}

	// 追加予約情報存在チェック
	function checkAdditionalResavationinfo(){
		var addtionData = false;
		$('.additional-resavation-info'+':text').each(function(i) {
		    var inputData = $(this).val();
		    if(inputData){
			    // データあり
		    	addtionData = true;
		    }
		});

		// 追加予約情報あり（表示）
		if(addtionData){
			$('#collapseResavationInfo').collapse('show');
		}
	}


	function downloadFile(formObj, action, file_seq){
		$('#_file_seq').val(file_seq);
		$(formObj).attr('action', action);
		$(formObj).submit();
	}

	function getReportType(){

		$.ajax({
			type: 'POST',
	       	url: '/p/chirp/report/change',
			dataType: 'html',
			data:{
				'report_type':$('#report_type').val(),
				'_report_class':$('#_report_class').val(),
				'_report_status':$('#_report_status').val(),
				'_mode':$('#_mode').val()
			}
		})
		.done(function(data, textStatus, jqXHR){

				$('#category').html(data);

	   	})
	   	.fail(function(jqXHR, textStatus, errorThrown) {

			alert('カテゴリ取得に失敗しました');
		})
		.always(function(data, textStatus, errorThrown){

		});

	}


	function getComment(){

		$.ajax({
			type: 'POST',
	       	url: '/p/chirp/report/comment',
			dataType: 'html',
			data:{
				'report_no':$('#_report_no').val(),
				'_report_class':$('#_report_class').val()
			}
		})
		.done(function(data, textStatus, jqXHR){

				$('#comment').html(data);

	   	})
	   	.fail(function(jqXHR, textStatus, errorThrown) {

			alert('コメント取得に失敗しました');
		})
		.always(function(data, textStatus, errorThrown){


		});
	}

	$(function(){

		$(".datepicker").datepicker();

		$(window).load(function () {

			if($('#_report_class').val() == 1){

				if($('#sub_category_other_check').prop('checked')){

					$('#sub_category').prop('disabled', true);

				}else{
					$('#sub_category_other').prop('disabled', true);
				}

			}
			if($('#_report_class').val() == 4){
				getReportType();
			}

			<?php if(count($error_message_list) <= 0){ ?>
			if($('#_mode').val() == 'inquiry'){
				var position = $("#Inquiry").offset().top;
				$(window).scrollTop(position);
			}
			<?php }?>
			getComment();

			if($('#_has_additional_pax_info').val() == 1){
				$('#collapsePaxInfo').collapse('show');
			}
			if($('#_has_additional_resavation_info').val() == 1){
				$('#collapseResavationInfo').collapse('show');
			}


			// 追加お客様情報チェック
			checkAdditionalPaxinfo();
			// 追加予約情報チェック
			checkAdditionalResavationinfo();

			// Ajax取得時間を遅延させて実行
			setTimeout(function() {
				errorcategory();
				loadcategory();
				}, 1000);
		});

		$('#sub_category_other_check').on('change', function(){

			if($(this).prop('checked')){

				$('#sub_category').val('');
				$('#sub_category').prop('disabled', true);
				$('#sub_category_other').prop('disabled', false);


			}else{

				$('#sub_category').prop('disabled', false);
				$('#sub_category_other').val('');
				$('#sub_category_other').prop('disabled', true);

			}
		});


	    $(".attache-file").on('change', function() {

			var index = $(this).data('attach-file-index');

			var value = $(this).val();
			if(value == ''){
				return;
			}

	        $('#dummy_file_' + index).text(value);
	    });

	    $(".attache-file-clear").on('click', function() {


			var index = $(this).data('attach-file-index');
	        $('#attach_file_' + index).val('');
	        $('#dummy_file_' + index).text('ファイル未選択');
	    });

	    $(".attache-file-delete").on('click', function() {

			var index = $(this).data('attach-file-index');
			var seq = $(this).data('attach-file-seq');
	        $('#delete_file_' + index).val(seq);

	        var parent = $(this).parents('li');//.addClass('hidden-element');
			parent.addClass('hidden-element');
	    });


		$("#report_type").on('change',function () {

			$.ajax({
				type: 'POST',
		       	url: '/p/chirp/report/change',
				dataType: 'html',
				data:{
					'report_type':$(this).val(),
					'_report_class':$('#_report_class').val(),
					'_report_status':$('#_report_status').val(),
					'_mode':$('#_mode').val()
				}
			})
			.done(function(data, textStatus, jqXHR){

					$('#category').html(data);

		   	})
		   	.fail(function(jqXHR, textStatus, errorThrown) {

				alert('カテゴリ取得に失敗しました');
			})
			.always(function(data, textStatus, errorThrown){


			});

			// カテゴリエリアの全消去
			// Ajax取得時間を遅延させて実行
			setTimeout(function() {
				errorcategory();
				clearcategory();
			}, 500);


			return false;
		});

		$('#collapseAttachFile').on('shown.bs.collapse', function () {

			$('#attachFileIcon').removeClass('glyphicon-plus');
			$('#attachFileIcon').addClass('glyphicon-minus');

		})
		$('#collapseAttachFile').on('hidden.bs.collapse', function () {

			$('.additional-attach-file').val('');
			$('.additional-attach-file-label').text('ファイル未選択');

			$('#attachFileIcon').removeClass('glyphicon-minus');
			$('#attachFileIcon').addClass('glyphicon-plus');
		})



		$('#collapsePaxInfo').on('shown.bs.collapse', function () {

			$('#paxInfoIcon').removeClass('glyphicon-plus');
			$('#paxInfoIcon').addClass('glyphicon-minus');

		})
		$('#collapsePaxInfo').on('hidden.bs.collapse', function () {


			$('.additional-pax-info').val('');
			$('.additional-pax-info').attr("selected",false);

			$('#paxInfoIcon').removeClass('glyphicon-minus');
			$('#paxInfoIcon').addClass('glyphicon-plus');
		})

		$('#collapseResavationInfo').on('shown.bs.collapse', function () {

			if($('#record_locator_2').val() + $('#departure_date_2').val() + $('#flight_number_2').val() == ''){
				$('#flight_number_2').val('MM');
			}

			$('#resavationInfoIcon').removeClass('glyphicon-plus');
			$('#resavationInfoIcon').addClass('glyphicon-minus');

		})
		$('#collapseResavationInfo').on('hidden.bs.collapse', function () {

			$('.additional-resavation-info').val('');
			$('.additional-resavation-info').attr("selected",false);

			$('#resavationInfoIcon').removeClass('glyphicon-minus');
			$('#resavationInfoIcon').addClass('glyphicon-plus');
		})


	});
	</script>

</head>

<body>

	<!-- ヘッダー -->
	<?= $parts_common_header ?>

	<div class="container-fluid" style="font-size:97%">
		<form id="mainForm" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" id="_mode" name="_mode" value="<?= HTML::entities($_mode) ?>"/>
			<input type="hidden" id="_report_no" name="_report_no" value="<?= HTML::entities($report_info->report_no) ?>"/>
			<input type="hidden" id="_report_class" name="_report_class" value="<?= HTML::entities($report_info->report_class) ?>"/>
			<input type="hidden" id="_report_status" name="_report_status" value="<?= HTML::entities($report_info->report_status) ?>"/>
			<input type="hidden" id="_file_seq" name="_file_seq" value=""/>
			<input type="hidden" id="_modified" name="_modified" value="<?= HTML::entities($report_info->update_timestamp) ?>"/>
			<input type="hidden" id="_has_additional_pax_info" name="_has_additional_pax_info" value="<?= HTML::entities($report_info->has_additional_pax_info) ?>"/>
			<input type="hidden" id="_has_additional_reservation_info" name="_has_additional_reservation_info" value="<?= HTML::entities($report_info->has_additional_reservation_info) ?>"/>


			<!-- エラーメッセージ表示エリア -->
			<?= $parts_common_error ?>


			<!-- レポート個別アラートボタンエリア -->
			<?= $parts_report_alert_button ?>

			<div id="content" class="clearfix">
				<div class="left_side">
					<?php if(strlen(trim($parts_flight_info_area))): ?>
					<div class="form_cate clearfix">
						<div class="cate_title">Flight Information</div>
						<!-- フライト個別エリア -->
						<?= $parts_flight_info_area ?>
					</div>
					<?php endif; ?>

					<div class="form_cate clearfix">
						<div class="cate_title">Report Information</div>

						<!-- レポート個別エリア -->
						<?= $parts_report_individuals_area ?>

						<!-- 添付ファイル -->
						<?= $parts_report_attached_file_area ?>

						<!-- 関連レポートエリア -->
						<?= $parts_report_related_report_area ?>

						<!-- 備考欄エリア -->
						<?= $parts_remarks_area ?>
					</div>

					<!-- 予約情報エリア -->
					<?php if($report_info->report_class == 1){ ?>
					<div class="form_cate clearfix">
						<div class="cate_title">Reservation Information</div>
						<?= $parts_resavation_info_area ?>
					</div>
					<?php }?>
				</div>

				<div class="right_side">
					<div class="form_cate clearfix">
						<div class="cate_title">Report Definition</div>
						<!-- 設定エリア -->
						<?= $parts_report_config_area ?>

						<!-- レポートステータスエリア -->
						<?php if($report_info->report_no){ ?>
								<?= $parts_report_status_area ?>
						<?php }?>

						<!-- レポート定義個別エリア -->
						<?= $parts_report_definition_area ?>

					</div>

					<?php if(strlen(trim($parts_report_inquiry_area))): ?>
					<div class="form_cate clearfix <?= HTML::entities($role_manage_info->comment_area_hidden) ?>">
						<div id="Inquiry" class="cate_title">Inquiry</div>
						<!-- 照会エリア -->
						<?= $parts_report_inquiry_area ?>

					</div>
					<?php endif; ?>

					<div class="form_cate clearfix">
						<div class="cate_title">PAX Information</div>
						<!-- お客様情報エリア -->
						<?= $parts_report_pax_info_area ?>
						<!-- Phoenixエリア -->
						<?= $parts_report_phoenix_area ?>
					</div>

				</div>
			</div>

			<div id="pagetop">
				<a href="#top">▲Page Top</a>
			</div>
			<div id="footer">
				<!-- メール送信先選択エリア -->
				<?= $parts_report_send_mail_area ?>

				<!-- ボタンエリア -->
				<?= $parts_report_button_area ?>
			</div>

		</form>
	</div>

</body>
</html>