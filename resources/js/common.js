function disableBrowserBack(){

	//History API が使えるブラウザかどうかをチェック
	if( window.history && window.history.pushState ){
	  //. ブラウザ履歴に１つ追加
	  history.pushState( "nohb", null, "" );
	  $(window).on( "popstate", function(event){
	    //. このページで「戻る」を実行
	    if( !event.originalEvent.state ){
	      //. もう一度履歴を操作して終了
	      history.pushState( "nohb", null, "" );
	      return;
	    }
	  });
	}
}

function exec(formObj, action){

	//showIndicator(true, 0.4);
	$('button').prop("disabled", true);
	$('a').addClass("avoid-clicks");
	$(formObj).attr('action', action);
	$(formObj).submit();
}

function execWithConfirm(formObj, action, message){

	if(confirm(message)){
		$('button').prop("disabled", true);
		$('a').addClass("avoid-clicks");
		$(formObj).attr('action', action);
		$(formObj).submit();
	}
}

function execCancel(formObj, action, message){

	var mode = $('#_mode').val();

	if( mode == 'reference' ||
		mode == 'other' ||
		mode == 'relation'
	){
		exec(formObj, action);
	}else{
		execWithConfirm(formObj, action, message);
	}
}

/**
 * テーブルレイアウト設定
 */
function settingTable(selector, pageLength, ordering, info, paging){


	$(function(){
			$(selector).dataTable({

				// 件数表示
				"info":info,
				// 表示件数
				"pageLength": pageLength,
				// 検索
				"searching":false,
				"autoWidth":true,
				// 表示件数変更
				"lengthChange":false,
				// ソート
				"ordering":ordering,
				"order":[],
				"processing":true,
				// ページング
				"paging":paging
//				"language": {
//					"processing":   "処理中...",
//				    "lengthMenu":   "_MENU_ 件表示",
//				    "emptyTable":    "データはありません",
//				    "zeroRecords":  "データはありません。",
//				    "info":         " _TOTAL_ 件中 _START_ から _END_ まで表示",
//				    "infoEmpty":    " 0 件中 0 から 0 まで表示",
//				    "infoFiltered": "（全 _MAX_ 件より抽出）",
//				    "infoPostFix":  "",
//				    "search":       "検索:",
//				    "url":          "",
//				    "paginate": {
//				        "first":    "先頭",
//				        "previous": "前",
//				        "next":     "次",
//				        "last":     "最終"
//				    }
//			    }
			});
	});
}



function showDialog(){

	$(function(){
		$('#groupEditModal').modal('show');
	});
}

//
//function settingDialog(){
//
//	$(function(){
//		// ダイアログ表示前にJavaScriptで操作する
//		$('#groupEditModal').on('show.bs.modal', function (event) {
//			var button = $(event.relatedTarget);
//			var data = button.data;
//		});
//	});
//}



var l;
function showLaddaIndicator(data){

	var ajaxStatus = data.status;
    switch(ajaxStatus){
		case "begin":
			l = Ladda.create( document.querySelector( '.ladda-button' ) );
			l.start();
			console.log('ajax:begin');
			break;
		case "complete":
			l.stop();
			console.log('ajax:complete');
			break;
		case "success":
			console.log('ajax:success');
			break;
	}
 }

function showActivityIndicator(data){
	var ajaxStatus = data.status;
    switch(ajaxStatus){
		case "begin":
			console.log('ajax:begin');
			showBlockIndicator();
			break;
		case "complete":
			console.log('ajax:complete');
			hideIndicator();
			break;
		case "success":
			console.log('ajax:success');
			break;
	}
}




var isShow = false;
function setConfirm(selector, message){

	$(function(){
	  	$(document).on('click',selector,function(event) {

	  		if(!isShow){

	  			var ajaxEvent = event;
	  			isShow = true;
		  		bootbox.dialog({
					message:message,
					title: '確認',
					closeButton: false,
					locale:'ja',
					buttons: {
						CANCEL: {
							label: 'キャンセル',
							className: "btn-gray btn-lg btn-block bootboxButton",
							colClassName:'col-md-4 col-md-offset-2',
							callback: function() {
								isShow = false;
								bootbox.hideAll();
							}
						},
						OK: {
							label: "OK",
							className: "btn-signage btn-lg btn-block bootboxButton",
							colClassName:'col-md-4',
							callback: function() {
								isShow = false;
								bootbox.hideAll();

								//var id = $(selector).attr('id');
					  			//document.getElementById(id).click();


								jsf.ajax.request(event.target, event,
						 		  	     {
						 		  		   execute:'@form',
						 		  		   render: '@form',
						 		  		   onevent:showActivityIndicator
						 		  	     }
						 		 );
						  		//event.preventDefault();
							}
						}
					}
				});
	  		}
	  		event.preventDefault();
		});
	});
}


/**
 * インジケータを表示する(ブロックあり、背景:黒)
 */
function showBlockIndicator(){
	showIndicator(true, 0.4);
}

/**
 * インジケータを表示する(ブロックあり、背景:白)
 */
function showBlockWhiteIndicator(){
	showIndicator(true, 0);
}

/**
 * インジケータを表示する(ブロックなし)
 */
function showNoBlockIndicator(){
	showIndicator(false, 0);
}

/**
 * インジケータを表示する
 * @param isBlock ブロックするかどうか(default:true)
 * @param overlayOpacity 背景の透過率(default:0.4)
 */
function showIndicator(isBlock, overlayOpacity){

	$(function(){
		$.blockUI.defaults.css = {};
  		$.blockUI({
  			message:
  				'<div class="container">' +
  				'<div class="row">' +
				'<div class="col-md-12 text-center">' +
  				'<img src="/resources/js/img/ajax-loader.gif"/>' +
  				'</div>' +
  				'</div>' +
  				'</div>',
  			showOverlay:isBlock,
  			css: {
  				padding: 0,
  		        margin: 0,
  		      	top:'30%',
  		      	left:0,
  		      	width:'100%',
  		        cursor: 'wait'
  		     },
  		     overlayCSS:  {
  		    	 backgroundColor: '#000',
		         opacity: overlayOpacity,
		         cursor: 'wait'
  		     }
  		});
  	});
}

/**
 * インジケータを非表示にする
 * @param callback コールバック
 */
function hideIndicator(callback){
	$(function(){
		 $.unblockUI();
		 if(callback != null){
			 callback();
		 }
	});
}

/**
 * 行選択時の処理
 * @param callback コールバック
 * @returns {Boolean}
 */
function OnEditClick(callback){
  	callback();
	return false;
}

/**
 * 確認ダイアログ表示
 * @param button ボタン
 * @param message メッセージ
 * @param callback コールバック
 * @param validate バリデート
 */
function showConfirm(button, message, callback, validate){

	$(button).prop('disabled', true);
	if(validate != null){

		if(!validate()){
			$(button).prop('disabled', false);
			return false;
		}
	}

	bootbox.dialog({
			message:message,
			title: '確認',
			closeButton: false,
			locale:'ja',
			buttons: {
				CANCEL: {
					label: 'キャンセル',
					className: "btn-gray btn-lg btn-block bootboxButton",
					colClassName:'col-md-4 col-md-offset-2',
					callback: function() {
						$(button).prop('disabled', false);
						bootbox.hideAll();
					}
				},
				OK: {
					label: "OK",
					className: "btn-signage btn-lg btn-block bootboxButton",
					colClassName:'col-md-4',
					callback: function() {
						$(button).prop('disabled', false);
						callback();
					}
				}
			}
	});
	return false;
}

/**
 * 確認ダイアログ表示
 * @param message メッセージ
 * @param callback コールバック
 */
function showFunctionConfirm(message, callback){

	bootbox.dialog({
			message:message,
			title: '確認',
			closeButton: false,
			locale:'ja',
			buttons: {
				CANCEL: {
					label: 'キャンセル',
					className: "btn-gray btn-lg btn-block bootboxButton",
					colClassName:'col-md-4 col-md-offset-2',
					callback: function() {
						bootbox.hideAll();
					}
				},
				OK: {
					label: "OK",
					className: "btn-signage btn-lg btn-block bootboxButton",
					colClassName:'col-md-4',
					callback: function() {
						callback();
					}
				}
			}
	});
	return false;
}


/**
 * コメント入力ダイアログ表示
 * @param button ボタン
 */
function showCommentDialog(button, reportNo, reportClass, _mode){

	$(button).prop('disabled', true);

	var reportName;
	switch (reportClass) {
	case '1':
		reportName = 'PENGUIN';
		break;
	case '3':
		reportName = 'PEREGRINE_Incident';
		break;
	case '2':
		reportName = 'PEREGRINE_Irregularity';
		break;
	case '4':
		reportName = 'PEACOCK';
		break;
	default:
		break;
	}
	var html =

		'<nav class="navbar navbar-peach">' +
			'<div class="container-fluid">' +
				'<div id="main">' +
					'<p id="logo"></p>' +
					'<h1>Chirp - ' + reportName + '</h1>' +
				'</div>' +
			'</div>' +
		'</nav>' +
		'<div class="row">' +
			'<div id="modal_error" class="col-md-12">' +
			'</div>' +
		'</div>' +
			'<div class="well">' +
				'<form onsubmit="return false;">' +
					'<div class="form-horizontal">' +
						'<div class="form-group">' +
							'<label for="Comments" class="col-md-3 control-label text-right">Comments</label>' +
							'<div class="col-md-8">' +
								'<textarea type="text" name="modal_comment" id="modal_comment" cols="100" rows="5" class="form-control no-resize-horizontal-textarea" maxlength="1500"></textarea>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div class="form-horizontal">' +
						'<div class="form-group">' +
							'<label for="Author" class="col-md-3 control-label text-right">Author</label>' +
							'<div class="col-md-8">' +
								'<input type="text" name="modal_author" id="modal_author" class="form-control" maxlength="40">' +
							'</div>' +
						'</div>' +
					'</div>' +
				'</form>' +
			'</div>' +
		'</div>';


	bootbox.dialog({
			message:html,
			closeButton: false,
			locale:'ja',
			buttons: {
				CANCEL: {
					label: 'Cancel',
					className: "btn-pink btn-sm btn-block bootboxButton",
					colClassName:'col-md-2 col-md-offset-3',
					callback: function() {
						$(button).prop('disabled', false);
						bootbox.hideAll();
					}
				},
				OK: {
					label: "Save",
					className: "btn-pink btn-sm btn-block bootboxButton",
					colClassName:'col-md-2 col-md-offset-2',
					callback: function() {

						$('#modal_error').html('');
						var comment = $('#modal_comment').val();
						var author = $('#modal_author').val();


						if(comment.trim() == '' || author == ''){

							$('#modal_error').html('<div class="alert alert-danger"><button class="close" data-dismiss="alert">&#215;</button><ul><li>CommentsとAuthorは入力必須です。</li></ul></div>');
							return false;
						}else{


							$(button).prop('disabled', false);


							$.ajax({
								type: 'POST',
						       	url: '/p/chirp/report/add-comment',
								dataType: 'html',
								data:{
									'modal_comment':comment,
									'modal_author':author,
									'modal_report_no':reportNo,
									'_report_class':reportClass,
									'_mode':_mode
								}
							})
							.done(function(data, textStatus, jqXHR){

									$('#comment').html(data);

						   	})
						   	.fail(function(jqXHR, textStatus, errorThrown) {

								alert('コメント登録に失敗しました');
							})
							.always(function(data, textStatus, errorThrown){


							});
						}
					}
				}
			}
	});
	return false;
}

/**
 * アップロードプログレスダイアログ表示
 * @param button ボタン
 * @param callback コールバック
 */
function showUploadProgressDialog(data){

	var html =
		'<div class="row">' +
			'<div class="col-md-12">' +
				'<h2></h2>'+
				'<div class="progress">'+
					'<div class="progress-bar progress-bar-info" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">'+
					'</div>'+
				'</div>'+
			'</div>' +
		'</div>'

	var jqXHR;
	bootbox.dialog({
			message:html,
			title: '処理中...',
			closeButton: false,
			locale:'ja',
			buttons: {
				CANCEL: {
					label: 'キャンセル',
					className: "btn-gray btn-lg btn-block bootboxButton",
					colClassName:'col-md-4 col-md-offset-4',
					callback: function() {
						jqXHR.abort();
						bootbox.hideAll();
					}
				}
			}
	});
	jqXHR = data.submit();
	return false;
}

/**
 * アップロードプログレスダイアログ設定
 * @param apiUrl APIのURL
 * @param listUrl 一覧画面のURL
 */
function setUploadProgress(apiUrl, listUrl){

	$(function () {

  		$('#selectFile').on('click', function() {
  		  $('#upload_file').trigger('click');
  		});

  		$('#upload_file').change(function() {
  		  $('#selectedFile').val($(this).val());
  		});

  		$('#upload_file').fileupload({
			url:apiUrl,
		    dataType: 'json',
		    autoUpload : false,
		    add: function (e, data) {

	            $('#uploadButton').on('click',function () {

	            	showUploadProgressDialog(data);
	            	return false;
	            });
	        },
		    progressall: function (e, data) {
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        $('.progress-bar').css(
		            'width',
		            progress + '%'
		        );
		        $('.progress-bar').html(progress + '%');
		    },
		    done: function (data, textStatus, jqXHR ) {

		    		bootbox.hideAll();
		    	    location.replace(listUrl);
	        },
		    fail: function(jqXHR, textStatus, errorThrown) {

		    	if (textStatus.errorThrown === 'abort') {
		            console.log('File Upload has been canceled');
		        }else{
		    		console.log('upload error!');
		        }
		    	$('.progress-bar').css('width','0%');
			    $('.progress-bar').html('0%');
		    	bootbox.hideAll();
		    	//location.reload();
		    }
		});
	});
}

/**
 * メッセージダイアログ表示
 * @param message メッセージ
 */
function showMessageDialog(message){

	bootbox.dialog({
		message:message,
		title: '確認',
		closeButton: false,
		locale:'ja',
		buttons: {
			OK: {
				label: "OK",
				className: "btn-signage btn-lg btn-block bootboxButton",
				colClassName:'col-md-4 col-md-offset-4',
				callback: function() {
					bootbox.hideAll();
				}
			}
		}
	});
}