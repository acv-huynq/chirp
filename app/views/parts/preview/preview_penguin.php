		<table id="" class="table" border="0" cellpadding="2" style="width: 100%; text-align: left; table-layout:fixed; word-wrap: break-word;">
			<tbody>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Own Department Only</div>他部門非公開</td>
					<td class="preview_data"><?php echo ($report_info->own_department_only_flag === '1' ? 'On' : 'Off')?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Report No</div>レポート番号</td>
					<td class="preview_data"><?=HTML::entities($report_info->report_no)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Station</div>起票部署</td>
					<td class="preview_data"><?=HTML::entities($report_info->station)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Report Title</div>レポート件名</td>
					<td class="preview_data"><?=HTML::entities($report_info->report_title)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Line</div>回線</td>
					<td class="preview_data"><?=HTML::entities($report_info->line)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">First Contact</div>入電日時</td>
					<td class="preview_data"><?=HTML::entities($report_info->first_contatct_date)?> <?=HTML::entities($report_info->first_contact_time)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Last Contact</div>最終通話日時</td>
					<td class="preview_data"><?=HTML::entities($report_info->last_contact_date)?> <?=HTML::entities($report_info->last_contact_time)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Category</div>カテゴリ</td>
					<td class="preview_data"><?=HTML::entities($report_info->category_name)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Sub Category</div>サブカテゴリ</td>
					<td class="preview_data"><?=HTML::entities($report_info->sub_category)?><?=HTML::entities($report_info->sub_category_other)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Contents</div>クレーム内容</td>
					<td class="preview_data"><?=nl2br(HTML::entities($report_info->contents))?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Correspondence</div>対応内容</td>
					<td class="preview_data"><?=nl2br(HTML::entities($report_info->correspondence))?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Attachments</div>添付ファイル</td>
					<td class="preview_data"><?=HTML::entities($report_info->attach_file_list)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Related Report</div>関連レポート</td>
					<td class="preview_data"><?=HTML::entities($report_info->related_report_list)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Remarks</div>備考</td>
					<td class="preview_data"><?=nl2br(HTML::entities($report_info->free_comment))?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 First Name</div>名前</td>
					<td class="preview_data"><?=HTML::entities($report_info->firstname)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Last Name</div>苗字</td>
					<td class="preview_data"><?=HTML::entities($report_info->lastname)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Gender</div>性別</td>
					<td class="preview_data"><?=HTML::entities($report_info->title_rcd)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Birthday</div>生年月日</td>
					<td class="preview_data"><?=HTML::entities($report_info->birthday)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Phone Number ①</div>電話番号 ①</td>
					<td class="preview_data"><?=HTML::entities($report_info->phone_number1)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Phone Number ②</div>電話番号 ②</td>
					<td class="preview_data"><?=HTML::entities($report_info->phone_number2)?></td>
				</tr>
				<?php if($report_info->pax_info_2_flg || $report_info->pax_info_3_flg): ?>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 First Name</div>名前</td>
					<td class="preview_data"><?=HTML::entities($report_info->firstname_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Last Name</div>苗字</td>
					<td class="preview_data"><?=HTML::entities($report_info->lastname_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Gender</div>性別</td>
					<td class="preview_data"><?=HTML::entities($report_info->title_rcd_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Birthday</div>生年月日</td>
					<td class="preview_data"><?=HTML::entities($report_info->birthday_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Phone Number ①</div>電話番号 ①</td>
					<td class="preview_data"><?=HTML::entities($report_info->phone_number1_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Phone Number ②</div>電話番号 ②</td>
					<td class="preview_data"><?=HTML::entities($report_info->phone_number2_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#3 First Name</div>名前</td>
					<td class="preview_data"><?=HTML::entities($report_info->firstname_3)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#3 Last Name</div>苗字</td>
					<td class="preview_data"><?=HTML::entities($report_info->lastname_3)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#3 Gender</div>性別</td>
					<td class="preview_data"><?=HTML::entities($report_info->title_rcd_3)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#3 Birthday</div>生年月日</td>
					<td class="preview_data"><?=HTML::entities($report_info->birthday_3)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#3 Phone Number ①</div>電話番号 ①</td>
					<td class="preview_data"><?=HTML::entities($report_info->phone_number1_3)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#3 Phone Number ②</div>電話番号 ②</td>
					<td class="preview_data"><?=HTML::entities($report_info->phone_number2_3)?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 PNR</div>予約番号</td>
					<td class="preview_data"><?=HTML::entities($report_info->record_locator)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Flight Date</div>フライト日</td>
					<td class="preview_data"><?=HTML::entities($report_info->departure_date)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#1 Flight No</div>便名</td>
					<td class="preview_data"><?=HTML::entities($report_info->flight_number)?></td>
				</tr>
				<?php if($report_info->flight_info_2_flg): ?>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 PNR</div>予約番号</td>
					<td class="preview_data"><?=HTML::entities($report_info->record_locator_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Flight Date</div>フライト日</td>
					<td class="preview_data"><?=HTML::entities($report_info->departure_date_2)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">#2 Flight No</div>便名</td>
					<td class="preview_data"><?=HTML::entities($report_info->flight_number_2)?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Phoenix Class</div>Phoenixカテゴリ</td>
					<td class="preview_data"><?=HTML::entities($report_info->phoenix_class)?></td>
				</tr>
				<tr style="border-bottom: 1px solid #ddd;">
					<td class="preview_header"><div class="preview_header_al">Phoenix Memo</div>Phoenixメモ</td>
					<td class="preview_data"><?=nl2br(HTML::entities($report_info->phoenix_memo))?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Report Status</div>レポートステータス</td>
					<td class="preview_data"><?=HTML::entities($report_info->report_status_name)?></td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Created</div>作成日</td>
					<td class="preview_data"><?=HTML::entities($report_info->create_timestamp)?> JST</td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Modified</div>更新日</td>
					<td class="preview_data"><?=HTML::entities($report_info->update_timestamp)?> JST</td>
				</tr>
				<tr>
					<td class="preview_header"><div class="preview_header_al">Reported By</div>起票者</td>
					<td class="preview_data"><?=HTML::entities($report_info->reported_by)?></td>
				</tr>
			</tbody>
		</table>
