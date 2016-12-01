<?php

return [

	// ログイン画面
	'SELECT_USER_INFO'					=>	'select * from mst_user_info where login_id = ?',

	// トップ画面（PENGUIN)
	'SELECT_INQUIRY_REPORT_PENGUIN'		=>	'select DATE_FORMAT(penguin_inquiry_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as inquiry_timestamp,report_no,case when CHAR_LENGTH(reported_by) > 15  then concat(left(reported_by,12),"...") else reported_by end as reported_by,case report_class when 1 then "PENGUIN" when 2 then "PEREGRINE" when 3 then "PEREGRINE" when 4 then "PEACOCK" else "-" end inquery_from,report_class,report_status from report_basic_info where penguin_inquiry_status = ? and delete_flag <> ?  order by penguin_inquiry_timestamp desc',
	'SELECT_NEW_REPORT_PENGUIN'			=>
		'select '
		.'t1.report_no, '
		.'t1.report_class, '
		.'t6.value2 as report_status_name, '
		.'case '
		.'when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...") '
		.'else t1.report_title '
		.'end as report_title, '
// 		.'t2.station, '
		.'t3.value2 as station, '
		.'case '
		.'when CHAR_LENGTH(t1.reported_by) > 15 then concat(left(t1.reported_by,12),"...") '
		.'else t1.reported_by '
		.'end as reported_by, '
// 		.'t2.category, '
		.'t4.value2 as category, '
// 		.'t2.sub_category, '
		.'t5.value2 as sub_category, '
		.'DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as update_timestamp, '
		.'case '
		. '  when t1.peregrine_inquiry_status = "2" or t1.peacock_inquiry_status = "2" then "回答済" '
		. '  when t1.peregrine_inquiry_status = "3" or t1.peacock_inquiry_status = "3" then "回答閲覧済" '
		. '  when t1.peregrine_inquiry_status = "1" or t1.peacock_inquiry_status = "1" then "照会中" '
		.'else "-"  '
		.'end as inquiry_status '
		.'from report_basic_info t1 '
		.'inner join report_info_penguin t2 on t1.report_no = t2.report_no '
		.'left outer  join mst_system_code t3 on t3.code1 = "Station" and (t3.report_class = t1.report_class or t3.report_class = 0) and t2.station = t3.code2 '
		.'left outer join mst_system_code t4 on t4.code1 = "Category" and (t4.report_class = t1.report_class or t4.report_class = 0) and t2.category = t4.code2 '
		.'left outer join mst_system_code t5 on t5.code1 = "Sub Category" and (t5.report_class = t1.report_class or t5.report_class = 0) and t2.sub_category = t5.code2 '
		.'left outer join mst_system_code t6 on t6.code1 = "Report Status" and t1.report_status = t6.code2 '
		.'where t1.report_class = ? and t1.report_status <> ? and t1.delete_flag <> ? '
		.'order by t1.update_timestamp desc ',


	// トップ画面（PEREGRINE)
	'SELECT_INQUIRY_REPORT_PEREGRINE'	=>	'select DATE_FORMAT(peregrine_inquiry_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as inquiry_timestamp,report_no,case when CHAR_LENGTH(reported_by) > 15  then concat(left(reported_by,12),"...") else reported_by end as reported_by ,case report_class when 1 then "PENGUIN" when 2 then "PEREGRINE" when 3 then "PEREGRINE" when 4 then "PEACOCK" else "-" end inquery_from,report_class,report_status from report_basic_info where peregrine_inquiry_status = ? and delete_flag <> ?  order by peregrine_inquiry_timestamp desc',
	'SELECT_NEW_REPORT_PEREGRINE'			=>
		'select '
		.'t4.value2 as report_status_name, '
		.'t1.report_no, '
		.'t1.report_class, '
		.'case '
		.'when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...") '
		.'else t1.report_title '
		.'end as report_title, '
// 		.'t2.station, '
		.'t3.value2 as station, '
		.'case '
		.'when CHAR_LENGTH(t1.reported_by) > 15 then concat(left(t1.reported_by,12),"...") '
		.'else t1.reported_by '
		.'end as reported_by, '
		.'DATE_FORMAT(t2.reporting_date,\'%Y/%m/%d\') as reporting_date, '
		.'t2.flight_number, '
		.'DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as update_timestamp, '
		.'case '
		. '  when t1.penguin_inquiry_status = "2" or t1.peacock_inquiry_status = "2" then "回答済" '
		. '  when t1.penguin_inquiry_status = "3" or t1.peacock_inquiry_status = "3" then "回答閲覧済" '
		. '  when t1.penguin_inquiry_status = "1" or t1.peacock_inquiry_status = "1" then "照会中" '
		.'else "-" '
		.'end as inquiry_status '
		.'from report_basic_info t1 '
		.'inner join report_info_peregrine t2 on t1.report_no = t2.report_no '
		.'left outer  join mst_system_code t3 on t3.code1 = "Station" and (t3.report_class = t1.report_class or t3.report_class = 0) and t2.station = t3.code2 '
		.'left outer join mst_system_code t4 on t4.code1 = "Report Status" and t1.report_status = t4.code2 '
		.'where t1.report_class = ? and t1.report_status <> ? and t1.delete_flag <> ? ',
		// 		.'and t2.station = ? ',

	// トップ画面（PEACOCK)
	'SELECT_INQUIRY_REPORT_PEACOCK'		=>	'select DATE_FORMAT(peacock_inquiry_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as inquiry_timestamp,report_no,case when CHAR_LENGTH(reported_by) > 15  then concat(left(reported_by,12),"...") else reported_by end as reported_by,case report_class when 1 then "PENGUIN" when 2 then "PEREGRINE" when 3 then "PEREGRINE" when 4 then "PEACOCK" else "-" end inquery_from,report_class,report_status from report_basic_info where peacock_inquiry_status = ? and delete_flag <> ?  order by peacock_inquiry_timestamp desc',
// 	'SELECT_NEW_REPORT_PEACOCK'			=>	'select case t1.report_status when 0 then "pending" when 1 then "submitted" when 2 then "confirmed" when 3 then "closed" else "-" end report_status_name,t1.report_status, t1.report_no,t1.report_title,t2.departure_date,t2.flight_number,t2.ship_no,t1.update_timestamp, case when t1.penguin_inquiry_status = "1" or t1.peregrine_inquiry_status = "1" then "照会中" when t1.penguin_inquiry_status = "2" or t1.peregrine_inquiry_status = "2" then "回答済" else "-"  end inquiry_status, t1.report_class from report_basic_info t1 inner join report_info_peacock t2 on t1.report_no = t2.report_no where t1.report_class = ? and t1.report_status <> ? and t1.delete_flag <> ? order by t1.update_timestamp desc',
// 	'SELECT_NEW_REPORT_PEACOCK'			=>	'select case t1.report_status when 0 then "pending" when 1 then "submitted" when 2 then "confirmed" when 3 then "closed" else "-" end report_status_name,t1.report_status, t1.report_no,case when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...") else t1.report_title end as report_title,DATE_FORMAT(t2.departure_date,\'%Y/%m/%d\') as departure_date,t2.flight_number,t2.ship_no,DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as update_timestamp, case when t1.penguin_inquiry_status = "2" or t1.peregrine_inquiry_status = "2" then "回答済" when t1.penguin_inquiry_status = "1" or t1.peregrine_inquiry_status = "1" then "照会中"  else "-"  end inquiry_status, t1.report_class from report_basic_info t1 inner join report_info_peacock t2 on t1.report_no = t2.report_no where t1.report_class = ? and t1.report_status <> ? and t1.delete_flag <> ? order by t1.update_timestamp desc',
	'SELECT_NEW_REPORT_PEACOCK'			=>
		'select '
		. 't4.value2 report_status_name, '
		. 't1.report_status, '
		. 't1.report_no,case when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...") else t1.report_title end as report_title, '
		. 'DATE_FORMAT(t2.departure_date,\'%Y/%m/%d\') as departure_date, '
		. 't2.flight_number, '
		. 't3.value2 as ship_no, '
		. 'DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as update_timestamp, '
		. 'case  '
		. '  when t1.penguin_inquiry_status = "2" or t1.peregrine_inquiry_status = "2" then "回答済" '
		. '  when t1.penguin_inquiry_status = "3" or t1.peregrine_inquiry_status = "3" then "回答閲覧済" '
		. '  when t1.penguin_inquiry_status = "1" or t1.peregrine_inquiry_status = "1" then "照会中" else "-" end inquiry_status, '
		. 't1.report_class '
		. 'from report_basic_info t1 '
		. 'inner join report_info_peacock t2 on t1.report_no = t2.report_no '
		. 'left outer join mst_system_code t3 on t3.code1 = "Ship No" and (t3.report_class = t1.report_class or t3.report_class = 0) and t2.ship_no = t3.code2 '
		. 'left outer join mst_system_code t4 on t4.code1 = "Report Status" and t1.report_status = t4.code2 '
		. 'where t1.report_class = ? '
		. 'and t1.report_status <> ? '
		. 'and t1.delete_flag <> ? '
		. 'order by t1.update_timestamp desc',

	// トップ画面（検索・PEACOCK)
	'SELECT_SEARCH_REPORT_PEACOCK'		=>
		'select '
		. ' t3.value2 as report_status_name,'
		. ' DATE_FORMAT(t2.reporting_date,\'%Y/%m/%d\') as reporting_date,'
		. ' t1.report_no,'		. ' case '
		. ' when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...")'
		. ' else t1.report_title'
		. ' end as report_title,'
		. ' t2.flight_number,'
		. ' case '
		. '  when t1.penguin_inquiry_status = "2" or t1.peregrine_inquiry_status = "2" then "回答済" '
		. '  when t1.penguin_inquiry_status = "3" or t1.peregrine_inquiry_status = "3" then "回答閲覧済" '
		. '  when t1.penguin_inquiry_status = "1" or t1.peregrine_inquiry_status = "1" then "照会中" '
		. '  else "-" '
		. ' end inquiry_status, '
		. ' t1.report_class, '
		. ' t1.report_status '
		. 'from report_basic_info t1'
		. ' inner join '
		. ' report_info_peacock t2'
		. ' on '
		. ' t1.report_no = t2.report_no'
		. ' left outer join mst_system_code t3 on t3.code1 = "Report Status" and t1.report_status = t3.code2 '
		. ' where '
		. '  t1.report_class = ? and t1.delete_flag <> ? ',

	// トップ画面（検索・PENGUIN)
	'SELECT_SEARCH_REPORT_PENGUIN'		=>
		'select '
		. ' t3.value2 as report_status_name,'
		. ' DATE_FORMAT(t2.first_contatct_date,\'%Y/%m/%d\') as reporting_date,'
		. ' t1.report_no,'
		. ' case '
		. ' when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...")'
		. ' else t1.report_title'
		. ' end as report_title,'
		. ' t2.flight_number,'
		. ' case '
		. '  when t1.peregrine_inquiry_status = "2" or t1.peacock_inquiry_status = "2" then "回答済" '
		. '  when t1.peregrine_inquiry_status = "3" or t1.peacock_inquiry_status = "3" then "回答閲覧済" '
		. '  when t1.peregrine_inquiry_status = "1" or t1.peacock_inquiry_status = "1" then "照会中" '
		. '  else "-" '
		. ' end inquiry_status, '
		. ' t1.report_class, '
		. ' t1.report_status '
		. 'from report_basic_info t1'
		. ' inner join '
		. ' report_info_penguin t2'
		. ' on '
		. ' t1.report_no = t2.report_no'
		. ' left outer join mst_system_code t3 on t3.code1 = "Report Status" and t1.report_status = t3.code2 '
		. ' where '
		. '  t1.report_class = ? and t1.delete_flag <> ? ',

	// トップ画面（検索・PEREGRINE)
	'SELECT_SEARCH_REPORT_PEREGRINE'		=>
		'select '
		. ' t3.value2 as report_status_name,'
		. ' DATE_FORMAT(t2.reporting_date,\'%Y/%m/%d\') as reporting_date,'
		. ' t1.report_no,'		. ' case '
		. ' when CHAR_LENGTH(t1.report_title) > 15 then concat(left(t1.report_title,12),"...")'
		. ' else t1.report_title'
		. ' end as report_title,'
		. ' t2.flight_number,'
		. ' case '
		. '  when t1.penguin_inquiry_status = "2" or t1.peacock_inquiry_status = "2" then "回答済" '
		. '  when t1.penguin_inquiry_status = "3" or t1.peacock_inquiry_status = "3" then "回答閲覧済" '
		. '  when t1.penguin_inquiry_status = "1" or t1.peacock_inquiry_status = "1" then "照会中" '
		. '  else "-" '
		. ' end inquiry_status, '
		. ' t1.report_class, '
		. ' t1.report_status '
		. 'from report_basic_info t1'
		. ' inner join '
		. ' report_info_peregrine t2'
		. ' on '
		. ' t1.report_no = t2.report_no'
		. ' left outer join mst_system_code t3 on t3.code1 = "Report Status" and t1.report_status = t3.code2 '
		. ' where '
		. '  t1.report_class = ? and t1.delete_flag <> ? ',


	// レポート画面(共通)
	'INSERT_REPORT_BASIC_INFO'			=>	'INSERT INTO report_basic_info(report_no,report_seq,report_class,own_department_only_flag,report_status,day_of_week,reported_by,report_title,contents,confirmor_id,approver_id,peacock_Inquiry_status,peacock_Inquiry_timestamp,penguin_Inquiry_status,penguin_Inquiry_timestamp,peregrine_inquiry_status,peregrine_inquiry_timestamp,old_report_no,related_report_no,related_report_no_2,firstname,lastname,title_rcd,birthday,phone_number1,phone_number2,record_locator,firstname_2,lastname_2,title_rcd_2,birthday_2,phone_number1_2,phone_number2_2,record_locator_2,firstname_3,lastname_3,title_rcd_3,birthday_3,phone_number1_3,phone_number2_3,record_locator_3,phoenix_class,phoenix_memo,free_comment,delete_flag,create_user_id,create_timestamp,update_user_id,update_timestamp)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
	'INSERT_REPORT_ATTACHE_FILE'		=>	'insert into report_attached_file(report_no,file_seq,file_name,file,create_timestamp) select ? ,case when max(file_seq) is null then 1 else max(file_seq) + 1 end, ?, ?, ? from report_attached_file where report_no = ?',
	'UPDATE_REPORT_BASIC_INFO'			=>	'UPDATE report_basic_info SET own_department_only_flag = ?, report_status = ?, day_of_week = ?, reported_by = ?, report_title = ?, contents = ?, confirmor_id = ?, approver_id = ?, old_report_no = ?, related_report_no = ?, related_report_no_2 = ?, firstname = ?, lastname = ?, title_rcd = ?, birthday = ?, phone_number1 = ?, phone_number2 = ?, record_locator = ?, firstname_2 = ?, lastname_2 = ?, title_rcd_2 = ?, birthday_2 = ?, phone_number1_2 = ?, phone_number2_2 = ?, record_locator_2 = ?, firstname_3 = ?, lastname_3 = ?, title_rcd_3 = ?, birthday_3 = ?, phone_number1_3 = ?, phone_number2_3 = ?, record_locator_3 = ?, phoenix_class = ?, phoenix_memo = ?, free_comment = ?, update_user_id = ?, update_timestamp = ? WHERE report_no = ? and update_timestamp = ?',
	'UPDATE_REPORT_BASIC_INFO_ONLY_REMARKS' 	=>	'UPDATE report_basic_info SET free_comment = ?, update_user_id = ?, update_timestamp = ? WHERE report_no = ? and update_timestamp = ?',
	'DELETE_REPORT_ATTACHE_FILE'		=>	'delete from report_attached_file where report_no = ? and file_seq = ?',

	'SELECT_MAX_FILE_SEQ'				=>	'select case when max(file_seq) is null then 1 else max(file_seq) + 1 end file_seq from report_attached_file where report_no = ?',
	'SELECT_REPORT_ATTACHE_FILE_LIST'	=>	'select file_seq,file_name from report_attached_file where report_no = ?',
	'SELECT_REPORT_ATTACHE_FILE'		=>	'select file_name,file from report_attached_file where report_no = ? and file_seq = ?',
	'SELECT_REPORT_COMMENT'				=>	'select report_no, comment_seq, comment, author, report_name, DATE_FORMAT(create_timestamp,\'%Y/%m/%d %H:%i:%S JST\') as create_timestamp from report_comment where report_no = ? order by comment_seq desc',
	'SELECT_MAX_REPORT_SEQ'				=>	'select case when max(report_seq) is null then 1 else max(report_seq) + 1 end report_seq from report_basic_info where report_no like ?',
	'INSERT_REPORT_COMMENT'				=>	'insert into report_comment(report_no,comment_seq,comment,author,report_name,create_timestamp) select ?, case when max(comment_seq) is null then 1 else max(comment_seq) + 1 end, ?, ?, ?, ? from report_comment where report_no = ?',
	'LOGICAL_DELETE_REPORT_BASIC_INFO'	=>	'update report_basic_info set delete_flag = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?',
	'EXECUTE_INQUIRY'					=>	[
			'PENGUIN'			=>	'update report_basic_info set peregrine_inquiry_status = ?, peregrine_inquiry_timestamp = ?, peacock_inquiry_status = ?, peacock_inquiry_timestamp = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?',
			'PEREGRINE'			=>	'update report_basic_info set penguin_inquiry_status = ?, penguin_inquiry_timestamp = ?, peacock_inquiry_status = ?, peacock_inquiry_timestamp = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?',
			'PEACOCK'			=>	'update report_basic_info set penguin_inquiry_status = ?, penguin_inquiry_timestamp = ?, peregrine_inquiry_status = ?, peregrine_inquiry_timestamp = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?'
	],
	'EXECUTE_ANSWER_TO_INQUIRY'			=>	[
			'PENGUIN'			=>	'update report_basic_info set penguin_inquiry_status = ?, penguin_inquiry_timestamp = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?',
			'PEREGRINE'			=>	'update report_basic_info set peregrine_inquiry_status = ?, peregrine_inquiry_timestamp = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?',
			'PEACOCK'			=>	'update report_basic_info set peacock_inquiry_status = ?, peacock_inquiry_timestamp = ?, update_user_id = ?, update_timestamp = ? where report_no = ? and update_timestamp = ?'
	],
	'SELECT_RELATED_REPORT_LIST'		=>	[
			'PENGUIN'			=>	'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_penguin t2 on t1.report_no = t2.report_no '
									. 'where ( '
									. '(t2.departure_date = ? and t2.flight_number = ?) or '
									. '(t2.departure_date_2 = ? and t2.flight_number_2 = ?)  or '
									. '(t2.departure_date = ? and t2.flight_number = ?) or '
									. '(t2.departure_date_2 = ? and t2.flight_number_2 = ?) '
									. ') '
									. 'and t1.report_no <> ? and t1.delete_flag <> 1 '
									. 'union all '
									. 'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_peacock t2 on t1.report_no = t2.report_no '
									. 'where '
									. '( '
									. '(t2.departure_date = ? and t2.flight_number = ?) or '
									. '(t2.departure_date = ? and t2.flight_number = ?) '
									. ') '
									. 'and t1.own_department_only_flag <> 1 '
									. 'and t1.delete_flag <> 1 '
									. 'union all '
									. 'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_peregrine t2 on t1.report_no = t2.report_no '
									. 'where '
									. '( '
									. '(t2.departure_date = ? and t2.flight_number = ?) or '
									. '(t2.departure_date = ? and t2.flight_number = ?) '
									. ') '
									. 'and t1.own_department_only_flag <> 1 '
									. 'and t1.delete_flag <> 1 '
									. 'order by report_no ;' ,
			'PEREGRINE'			=>	'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_peregrine t2 on t1.report_no = t2.report_no '
									. 'where '
									. '(t2.departure_date = ? and t2.flight_number = ?) '
									. 'and t1.report_no <> ? and t1.delete_flag <> 1 '
									. 'union all '
									. 'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_penguin t2 on t1.report_no = t2.report_no '
									. 'where ( '
									. '(t2.departure_date = ? and t2.flight_number = ?) or '
									. '(t2.departure_date_2 = ? and t2.flight_number_2 = ?) '
									. ') '
									. 'and t1.own_department_only_flag <> 1 '
									. 'and t1.delete_flag <> 1 '
									. 'union all '
									. 'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_peacock t2 on t1.report_no = t2.report_no '
									. 'where '
									. '(t2.departure_date = ? and t2.flight_number = ?) '
									. 'and t1.own_department_only_flag <> 1 '
									. 'and t1.delete_flag <> 1 '
									. 'order by report_no ;',
			'PEACOCK'			=>	'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_peacock t2 on t1.report_no = t2.report_no '
									. 'where '
									. '(t2.departure_date = ? and t2.flight_number = ?) '
									. 'and t1.report_no <> ? and t1.delete_flag <> 1 '
									. 'union all '
									. 'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_penguin t2 on t1.report_no = t2.report_no '
									. 'where ( '
									. '(t2.departure_date = ? and t2.flight_number = ?) or '
									. '(t2.departure_date_2 = ? and t2.flight_number_2 = ?)  '
									. ') '
									. 'and t1.own_department_only_flag <> 1 '
									. 'and t1.delete_flag <> 1 '
									. 'union all '
									. 'select t1.report_no, t1.report_class, t1.report_title '
									. 'from report_basic_info t1 '
									. 'inner join report_info_peregrine t2 on t1.report_no = t2.report_no '
									. 'where '
									. '(t2.departure_date = ? and t2.flight_number = ?) '
									. 'and t1.own_department_only_flag <> 1 '
									. 'and t1.delete_flag <> 1 '
									. 'order by report_no ;',
	],
	'EXSISTS_REPORT'			=>	'select count(report_no) count from report_basic_info where report_no = ? and delete_flag <> ?',

	// レポート画面(PEACOCK)
	'SELECT_REPORT_INFO_PEACOCK'	=>	'select t1.report_no,t1.report_seq,t1.report_class,t1.own_department_only_flag,case when (t1.firstname_2 is null and t1.lastname_2 is null and t1.title_rcd_2 is null and t1.birthday_2 is null and t1.phone_number1_2 is null and t1.phone_number2_2 is null and t1.record_locator_2 is null and t1.firstname_3 is null and t1.lastname_3 is null and t1.title_rcd_3 is null and t1.birthday_3 is null and t1.phone_number1_3 is null and t1.phone_number2_3 is null and t1.record_locator_3 is null) then 0 else 1 end has_additional_pax_info, 0 has_additional_reservation_info, t5.value2 report_status_name,t1.report_status,t1.day_of_week,t1.reported_by,t1.report_title,t1.contents,t1.confirmor_id,t1.approver_id,t1.peacock_inquiry_status,t1.peacock_inquiry_timestamp,t1.penguin_inquiry_status,t1.penguin_inquiry_timestamp,t1.peregrine_inquiry_status,t1.peregrine_inquiry_timestamp,t1.old_report_no,t1.related_report_no,t3.report_class related_report_class, t1.related_report_no_2, t4.report_class related_report_class_2, t1.firstname,t1.lastname,t1.title_rcd,DATE_FORMAT(t1.birthday,\'%Y/%m/%d\') birthday,t1.phone_number1,t1.phone_number2,t1.record_locator,t1.firstname_2,t1.lastname_2,t1.title_rcd_2,DATE_FORMAT(t1.birthday_2,\'%Y/%m/%d\') birthday_2,t1.phone_number1_2,t1.phone_number2_2,t1.record_locator_2,t1.firstname_3,t1.lastname_3,t1.title_rcd_3,DATE_FORMAT(t1.birthday_3,\'%Y/%m/%d\') birthday_3,t1.phone_number1_3,t1.phone_number2_3,t1.record_locator_3,t1.phoenix_class,t1.phoenix_memo,t1.free_comment,t1.delete_flag,t1.create_user_id,DATE_FORMAT(t1.create_timestamp,\'%Y/%m/%d %H:%i:%S\') create_timestamp,t1.update_user_id,DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S\') update_timestamp,t2.report_type,t2.flight_report_no,t2.added_by,DATE_FORMAT(t2.departure_date, "%Y/%m/%d") departure_date,t2.flight_number,t2.ship_no,t2.origin_rcd,t2.destination_rcd,t2.etd,t2.atd,t2.eta,t2.ata,t2.crew_cp,t2.crew_cap,t2.crew_r1,t2.crew_l2,t2.crew_r2,t2.pax_onboard,t2.pax_detail,t2.mr,t2.staff_comment,DATE_FORMAT(t2.reporting_date,\'%Y/%m/%d\') reporting_date, CASE WHEN (t1.penguin_inquiry_status = 2 OR t1.peregrine_inquiry_status = 2) THEN 1 ELSE 0 END as answer_read_button from report_basic_info t1 inner join report_info_peacock t2 on t1.report_no = t2.report_no left join report_basic_info t3 on t1.related_report_no = t3.report_no and t3.delete_flag <> ? left join report_basic_info t4 on t1.related_report_no_2 = t4.report_no and t4.delete_flag <> ? left outer join mst_system_code t5 on t5.code1 = "Report Status" and t1.report_status = t5.code2 where t1.report_no = ? and t1.delete_flag <> ?',
	'INSERT_REPORT_PEACOCK'			=>	'INSERT INTO report_info_peacock(report_no,report_type,flight_report_no,added_by,departure_date,flight_number,ship_no,origin_rcd,destination_rcd,etd,atd,eta,ata,crew_cp,crew_cap,crew_r1,crew_l2,crew_r2,pax_onboard,pax_detail,mr,staff_comment,reporting_date)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
	'UPDATE_REPORT_PEACOCK'			=>	'update report_info_peacock set report_type = ?,flight_report_no = ?,added_by = ?,departure_date = ?, flight_number = ?, ship_no = ?,origin_rcd = ?,destination_rcd = ?,etd = ?,atd = ?,eta = ?,ata = ?, crew_cp = ?,crew_cap = ?,crew_r1 = ?, crew_l2 = ?, crew_r2 = ?, pax_onboard = ?,pax_detail = ?, mr = ?, staff_comment = ?, reporting_date = ? where report_no = ?',
	'DELETE_SELECT_CATEGORY_INFO'	=>	'delete from select_category_info where report_no = ?',
	'INSERT_SELECT_CATEGORY_INFO'	=>	'insert into select_category_info values(?,?,?)',
	'SELECT_SELECT_CATEGORY_INFO'	=>	'select * from select_category_info where report_no = ?',

	// レポート画面(PENGUIN)
	'SELECT_REPORT_INFO_PENGUIN'	=>	'select t1.report_no,t1.report_seq,t1.report_class,t1.own_department_only_flag,case when (t1.firstname_2 is null and t1.lastname_2 is null and t1.title_rcd_2 is null and t1.birthday_2 is null and t1.phone_number1_2 is null and t1.phone_number2_2 is null and t1.firstname_3 is null and t1.lastname_3 is null and t1.title_rcd_3 is null and t1.birthday_3 is null and t1.phone_number1_3 is null and t1.phone_number2_3 is null) then 0 else 1 end has_additional_pax_info, case when (t1.record_locator_2 is null and t2.departure_date_2 is null and t2.flight_number_2 is null) then 0 else 1 end has_additional_reservation_info, t6.value2 report_status_name, t1.report_status, t1.day_of_week, t1.reported_by,t1.report_title,t1.contents,t1.confirmor_id,t1.approver_id,t1.peacock_inquiry_status,t1.peacock_inquiry_timestamp,t1.penguin_inquiry_status,t1.penguin_inquiry_timestamp,t1.peregrine_inquiry_status,t1.peregrine_inquiry_timestamp,t1.old_report_no,t1.related_report_no, t3.report_class related_report_class, t1.related_report_no_2, t4.report_class related_report_class_2,t1.firstname,t1.lastname,t1.title_rcd,DATE_FORMAT(t1.birthday,\'%Y/%m/%d\') birthday,t1.phone_number1,t1.phone_number2, t1.record_locator, t1.firstname_2, t1.lastname_2, t1.title_rcd_2,DATE_FORMAT(t1.birthday_2,\'%Y/%m/%d\') birthday_2, t1.phone_number1_2, t1.phone_number2_2, t1.record_locator_2, t1.firstname_3,t1.lastname_3,t1.title_rcd_3,DATE_FORMAT(t1.birthday_3,\'%Y/%m/%d\') birthday_3,t1.phone_number1_3, t1.phone_number2_3,t1.record_locator_3,t1.phoenix_class, t1.phoenix_memo,t1.free_comment,t1.delete_flag,t1.create_user_id,DATE_FORMAT(t1.create_timestamp,\'%Y/%m/%d %H:%i:%S\') create_timestamp, t1.update_user_id,DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S\') update_timestamp, t2.station, t2.line, DATE_FORMAT(t2.first_contatct_date, "%Y/%m/%d") first_contatct_date, t2.first_contact_time, DATE_FORMAT(t2.last_contact_date, "%Y/%m/%d") last_contact_date, t2.last_contact_time, t2.category, case when t5.value2 is null and t2.sub_category is not null then null else t2.sub_category end sub_category, t2.correspondence, DATE_FORMAT(t2.departure_date, "%Y/%m/%d") departure_date, t2.flight_number, DATE_FORMAT(t2.departure_date_2, "%Y/%m/%d") departure_date_2, t2.flight_number_2, t2.day_of_week, case when t5.value2 is null and t2.sub_category is not null then t2.sub_category else null end sub_category_other, CASE WHEN (t1.peacock_inquiry_status = 2 OR t1.peregrine_inquiry_status = 2) THEN 1 ELSE 0 END as answer_read_button from report_basic_info t1 inner join report_info_penguin t2 on t1.report_no = t2.report_no left join report_basic_info t3 on t1.related_report_no = t3.report_no and t3.delete_flag <> ? left join report_basic_info t4 on t1.related_report_no_2 = t4.report_no and t4.delete_flag <> ? left join mst_system_code t5 on t2.sub_category = t5.code2 and t5.code1 = ? left outer join mst_system_code t6 on t6.code1 = "Report Status" and t1.report_status = t6.code2  where t1.report_no = ? and t1.delete_flag <> ?',
	'INSERT_REPORT_PENGUIN'			=>	'insert into report_info_penguin(report_no,station,line,first_contatct_date,first_contact_time,last_contact_date,last_contact_time,category,sub_category,correspondence,departure_date,flight_number,departure_date_2,flight_number_2,day_of_week) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
	'UPDATE_REPORT_PENGUIN'			=>	'update report_info_penguin set station = ?,line = ?,first_contatct_date = ?,first_contact_time = ?,last_contact_date = ?,last_contact_time = ?,category = ?,sub_category = ?,correspondence = ?,departure_date = ?,flight_number = ?,departure_date_2 = ?,flight_number_2 = ?,day_of_week = ? where report_no = ?',

	// レポート画面(PEREGRINE)
	'SELECT_REPORT_INFO_PEREGRINE'	=>	'select t1.report_no,t1.report_seq,t1.report_class,t1.own_department_only_flag,case when (t1.firstname_2 is null and t1.lastname_2 is null and t1.title_rcd_2 is null and t1.birthday_2 is null and t1.phone_number1_2 is null and t1.phone_number2_2 is null and t1.record_locator_2 is null and t1.firstname_3 is null and t1.lastname_3 is null and t1.title_rcd_3 is null and t1.birthday_3 is null and t1.phone_number1_3 is null and t1.phone_number2_3 is null and t1.record_locator_3 is null) then 0 else 1 end has_additional_pax_info, 0 has_additional_reservation_info, t5.value2 report_status_name, t1.report_status,t1.day_of_week,t2.station, t1.reported_by,t1.report_title,t1.contents, t1.confirmor_id,t1.approver_id,t1.peacock_inquiry_status, t1.peacock_inquiry_timestamp,t1.penguin_inquiry_status, t1.penguin_inquiry_timestamp,t1.peregrine_inquiry_status, t1.peregrine_inquiry_timestamp,t1.old_report_no,t1.related_report_no, t3.report_class related_report_class, t1.related_report_no_2, t4.report_class related_report_class_2,t1.firstname,t1.lastname,t1.title_rcd,DATE_FORMAT(t1.birthday,\'%Y/%m/%d\') birthday, t1.phone_number1,t1.phone_number2,t1.record_locator,t1.firstname_2,t1.lastname_2, t1.title_rcd_2,DATE_FORMAT(t1.birthday_2,\'%Y/%m/%d\') birthday_2,t1.phone_number1_2,t1.phone_number2_2,t1.record_locator_2, t1.firstname_3,t1.lastname_3,t1.title_rcd_3,DATE_FORMAT(t1.birthday_3,\'%Y/%m/%d\') birthday_3,t1.phone_number1_3,t1.phone_number2_3, t1.record_locator_3,t1.phoenix_class,t1.phoenix_memo,t1.free_comment,t1.delete_flag,t1.create_user_id, DATE_FORMAT(t1.create_timestamp,\'%Y/%m/%d %H:%i:%S\') create_timestamp,t1.update_user_id,DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S\') update_timestamp, t2.station, t2.department, t2.position, DATE_FORMAT(t2.departure_date, "%Y/%m/%d") departure_date, t2.flight_number, t2.ship_no, t2.origin_rcd, t2.destination_rcd, t2.gate_spot, t2.weather, t2.std, t2.sta, t2.etd, t2.eta, t2.atd, t2.ata, t2.dla_code, t2.dla_time, t2.dla_code_2, t2.dla_time_2, t2.dla_code_3, t2.dla_time_3, t2.dla_ttl, t2.pax_in, t2.pax_out, DATE_FORMAT(t2.reporting_date, "%Y/%m/%d") reporting_date, t2.day_of_week, t2.area, t2.category, t2.factor, t2.measures_to_revent_recurrence, t2.influence_on_safety, t2.frequency, t2.approve_comment, t2.assessment, t2.staff_comment, CASE WHEN (t1.peacock_inquiry_status = 2 OR t1.penguin_inquiry_status = 2) THEN 1 ELSE 0 END as answer_read_button from report_basic_info t1 inner join report_info_peregrine t2 on t1.report_no = t2.report_no left join report_basic_info t3 on t1.related_report_no = t3.report_no and t3.delete_flag <> ? left join report_basic_info t4 on t1.related_report_no_2 = t4.report_no and t4.delete_flag <> ? left outer join mst_system_code t5 on t5.code1 = "Report Status" and t1.report_status = t5.code2 where t1.report_no = ? and t1.delete_flag <> ? ',
	'INSERT_REPORT_PEREGRINE'		=>	'insert into report_info_peregrine(report_no,station,department,position,departure_date,flight_number,ship_no,origin_rcd,destination_rcd,gate_spot,weather,std,sta,etd,eta,atd,ata,dla_code,dla_time,dla_code_2,dla_time_2,dla_code_3,dla_time_3,dla_ttl,pax_in,pax_out,reporting_date,day_of_week,area,category,factor,measures_to_revent_recurrence,influence_on_safety,frequency,approve_comment,assessment,staff_comment) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
	'UPDATE_REPORT_PEREGRINE'		=>	'update report_info_peregrine set station = ?,department = ?,position = ?,departure_date = ?,flight_number = ?,ship_no = ?,origin_rcd = ?,destination_rcd = ?,gate_spot = ?,weather = ?,std = ?,sta = ?,etd = ?,eta = ?,atd = ?,ata = ?,dla_code = ?,dla_time = ?,dla_code_2 = ?,dla_time_2 = ?,dla_code_3 = ?,dla_time_3 = ?,dla_ttl = ?,pax_in = ?,pax_out = ?,reporting_date = ?,day_of_week = ?,area = ?,category = ?,factor = ?,measures_to_revent_recurrence = ?,influence_on_safety = ?,frequency = ?,approve_comment = ?,assessment = ?,staff_comment = ? where report_no = ?',

	// プレビュー画面
	'SELECT_PREVIEW_PEACOCK'		=> '
SELECT
	t1.report_no,
	t1.report_seq,
	t1.report_class,
	t1.own_department_only_flag,
	CASE WHEN (t1.firstname_2 IS NULL AND t1.lastname_2 IS NULL AND t1.title_rcd_2 IS NULL AND t1.birthday_2 IS NULL AND t1.phone_number1_2 IS NULL AND t1.phone_number2_2 IS NULL AND t1.record_locator_2 IS NULL AND t1.firstname_3 IS NULL AND t1.lastname_3 IS NULL AND t1.title_rcd_3 IS NULL AND t1.birthday_3 IS NULL AND t1.phone_number1_3 IS NULL AND t1.phone_number2_3 IS NULL AND t1.record_locator_3 IS NULL) THEN 0 ELSE 1 END has_additional_pax_info,
	0 has_additional_reservation_info,
	t5.value2 report_status_name,
	t1.report_status,
	t1.day_of_week,
	t1.reported_by,
	t1.report_title,
	t1.contents,
	t1.confirmor_id,
	t1.approver_id,
	t1.related_report_no,
	t3.report_class related_report_class,
	t1.related_report_no_2,
	t4.report_class related_report_class_2,
	t1.firstname,
	t1.lastname,
	t1.title_rcd,
	DATE_FORMAT(t1.birthday,\'%Y/%m/%d\') birthday,
	t1.phone_number1,
	t1.phone_number2,
	t1.record_locator,
	t1.firstname_2,
	t1.lastname_2,
	t1.title_rcd_2,
	DATE_FORMAT(t1.birthday_2,\'%Y/%m/%d\') birthday_2,
	t1.phone_number1_2,
	t1.phone_number2_2,
	t1.record_locator_2,
	CASE WHEN (t1.firstname_2 IS NOT NULL OR t1.lastname_2 IS NOT NULL OR t1.title_rcd_2 IS NOT NULL OR t1.birthday_2 IS NOT NULL OR t1.phone_number1_2 IS NOT NULL OR t1.phone_number2_2 IS NOT NULL OR t1.record_locator_2 IS NOT NULL) THEN 1 ELSE 0 END pax_info_2_flg,
	t1.firstname_3,
	t1.lastname_3,
	t1.title_rcd_3,
	DATE_FORMAT(t1.birthday_3,\'%Y/%m/%d\') birthday_3,
	t1.phone_number1_3,
	t1.phone_number2_3,
	t1.record_locator_3,
	CASE WHEN (t1.firstname_3 IS NOT NULL OR t1.lastname_3 IS NOT NULL OR t1.title_rcd_3 IS NOT NULL OR t1.birthday_3 IS NOT NULL OR t1.phone_number1_3 IS NOT NULL OR t1.phone_number2_3 IS NOT NULL OR t1.record_locator_3 IS NOT NULL) THEN 1 ELSE 0 END pax_info_3_flg,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Phoenix class\' AND code2 = t1.phoenix_class LIMIT 1) phoenix_class,
	t1.phoenix_memo,
	t1.free_comment,
	t1.delete_flag,
	t1.create_user_id,
	DATE_FORMAT(t1.create_timestamp,\'%Y/%m/%d %H:%i:%S\') create_timestamp,
	t1.update_user_id,
	DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S\') update_timestamp,
	t2.report_type,
	t2.flight_report_no,
	t2.added_by,
	DATE_FORMAT(t2.departure_date, "%Y/%m/%d") departure_date,
	t2.flight_number,
	t2.ship_no,
	t2.origin_rcd,
	t2.destination_rcd,
	t2.etd,
	t2.atd,
	t2.eta,
	t2.ata,
	t2.crew_cp,
	t2.crew_cap,
	t2.crew_r1,
	t2.crew_l2,
	t2.crew_r2,
	t2.pax_onboard,
	t2.pax_detail,
	t2.mr,
	t2.staff_comment,
	DATE_FORMAT(t2.reporting_date,\'%Y/%m/%d\') reporting_date,
	(SELECT GROUP_CONCAT(CONCAT(code2, \' \', value2) SEPARATOR \', \') FROM mst_system_code WHERE code2 IN(SELECT category FROM select_category_info WHERE report_no = t1.report_no) ORDER BY disp_order) category_name
FROM report_basic_info t1
INNER JOIN report_info_peacock t2 ON t1.report_no = t2.report_no
LEFT JOIN report_basic_info t3 ON t1.related_report_no = t3.report_no AND t3.delete_flag <> ?
LEFT JOIN report_basic_info t4 ON t1.related_report_no_2 = t4.report_no AND t4.delete_flag <> ?
LEFT OUTER JOIN mst_system_code t5 ON t5.code1 = "Report Status" AND t1.report_status = t5.code2
WHERE t1.report_no = ? AND t1.delete_flag <> ?',
	'SELECT_PREVIEW_PENGUIN'		=> '
SELECT
	t1.report_no,
	t1.report_seq,
	t1.report_class,
	t1.own_department_only_flag,
	CASE WHEN (t1.firstname_2 IS NULL AND t1.lastname_2 IS NULL AND t1.title_rcd_2 IS NULL AND t1.birthday_2 IS NULL AND t1.phone_number1_2 IS NULL AND t1.phone_number2_2 IS NULL AND t1.firstname_3 IS NULL AND t1.lastname_3 IS NULL AND t1.title_rcd_3 IS NULL AND t1.birthday_3 IS NULL AND t1.phone_number1_3 IS NULL AND t1.phone_number2_3 IS NULL) THEN 0 ELSE 1 END has_additional_pax_info,
	CASE WHEN (t1.record_locator_2 IS NULL AND t2.departure_date_2 IS NULL AND t2.flight_number_2 IS NULL) THEN 0 ELSE 1 END has_additional_reservation_info,
	t6.value2 report_status_name,
	t1.report_status,
	t1.day_of_week,
	t1.reported_by,
	t1.report_title,
	t1.contents,
	t1.confirmor_id,
	t1.approver_id,
	t1.old_report_no,
	t1.related_report_no,
	t3.report_class related_report_class,
	t1.related_report_no_2,
	t4.report_class related_report_class_2,
	t1.firstname,
	t1.lastname,
	t1.title_rcd,
	DATE_FORMAT(t1.birthday,\'%Y/%m/%d\') birthday,
	t1.phone_number1,
	t1.phone_number2,
	t1.firstname_2,
	t1.lastname_2,
	t1.title_rcd_2,
	DATE_FORMAT(t1.birthday_2,\'%Y/%m/%d\') birthday_2,
	t1.phone_number1_2,
	t1.phone_number2_2,
	CASE WHEN (t1.firstname_2 IS NOT NULL OR t1.lastname_2 IS NOT NULL OR t1.title_rcd_2 IS NOT NULL OR t1.birthday_2 IS NOT NULL OR t1.phone_number1_2 IS NOT NULL OR t1.phone_number2_2 IS NOT NULL) THEN 1 ELSE 0 END pax_info_2_flg,
	t1.firstname_3,
	t1.lastname_3,
	t1.title_rcd_3,
	DATE_FORMAT(t1.birthday_3,\'%Y/%m/%d\') birthday_3,
	t1.phone_number1_3,
	t1.phone_number2_3,
	CASE WHEN (t1.firstname_3 IS NOT NULL OR t1.lastname_3 IS NOT NULL OR t1.title_rcd_3 IS NOT NULL OR t1.birthday_3 IS NOT NULL OR t1.phone_number1_3 IS NOT NULL OR t1.phone_number2_3 IS NOT NULL) THEN 1 ELSE 0 END pax_info_3_flg,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Phoenix class\' AND code2 = t1.phoenix_class LIMIT 1) phoenix_class,
	t1.phoenix_memo,
	t1.free_comment,
	t1.delete_flag,
	t1.create_user_id,
	DATE_FORMAT(t1.create_timestamp,\'%Y/%m/%d %H:%i:%S\') create_timestamp,
	t1.update_user_id,
	DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S\') update_timestamp,
	t2.station,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Line\' AND code2 = t2.line LIMIT 1) line,
	DATE_FORMAT(t2.first_contatct_date, "%Y/%m/%d") first_contatct_date,
	t2.first_contact_time,
	DATE_FORMAT(t2.last_contact_date, "%Y/%m/%d") last_contact_date,
	t2.last_contact_time,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Category\' AND code2 = t2.category LIMIT 1) category_name,
	CASE WHEN t5.value2 IS NULL AND t2.sub_category IS NOT NULL THEN NULL ELSE t2.sub_category END sub_category,
	t2.correspondence,
	t1.record_locator,
	DATE_FORMAT(t2.departure_date, "%Y/%m/%d") departure_date,
	t2.flight_number,
	t1.record_locator_2,
	DATE_FORMAT(t2.departure_date_2, "%Y/%m/%d") departure_date_2,
	t2.flight_number_2,
	CASE WHEN (t1.record_locator_2 IS NOT NULL OR t2.departure_date_2 IS NOT NULL OR t2.flight_number_2 IS NOT NULL) THEN 1 ELSE 0 END flight_info_2_flg,
	t2.day_of_week,
	CASE WHEN t5.value2 IS NULL AND t2.sub_category IS NOT NULL THEN t2.sub_category ELSE NULL END sub_category_other
FROM report_basic_info t1
INNER JOIN report_info_penguin t2 ON t1.report_no = t2.report_no
LEFT JOIN report_basic_info t3 ON t1.related_report_no = t3.report_no AND t3.delete_flag <> ?
LEFT JOIN report_basic_info t4 ON t1.related_report_no_2 = t4.report_no AND t4.delete_flag <> ?
LEFT JOIN mst_system_code t5 ON t2.sub_category = t5.code2 AND t5.code1 = ?
LEFT OUTER JOIN mst_system_code t6 ON t6.code1 = "Report Status" AND t1.report_status = t6.code2
WHERE t1.report_no = ? AND t1.delete_flag <> ?',
	'SELECT_PREVIEW_PEREGRINE'		=> '
SELECT
	t1.report_no,
	t1.report_seq,
	t1.report_class,
	t1.own_department_only_flag,
	CASE WHEN (t1.firstname_2 IS NULL AND t1.lastname_2 IS NULL AND t1.title_rcd_2 IS NULL AND t1.birthday_2 IS NULL AND t1.phone_number1_2 IS NULL AND t1.phone_number2_2 IS NULL AND t1.record_locator_2 IS NULL AND t1.firstname_3 IS NULL AND t1.lastname_3 IS NULL AND t1.title_rcd_3 IS NULL AND t1.birthday_3 IS NULL AND t1.phone_number1_3 IS NULL AND t1.phone_number2_3 IS NULL AND t1.record_locator_3 IS NULL) THEN 0 ELSE 1 END has_additional_pax_info,
	0 has_additional_reservation_info,
	t5.value2 report_status_name,
	t1.report_status,
	t1.day_of_week,
	t2.station,
	t1.reported_by,
	t1.report_title,
	t1.contents,
	t1.confirmor_id,
	t1.approver_id,
	t1.old_report_no,
	t1.related_report_no,
	t3.report_class related_report_class,
	t1.related_report_no_2,
	t4.report_class related_report_class_2,
	t1.firstname,
	t1.lastname,
	t1.title_rcd,
	DATE_FORMAT(t1.birthday,\'%Y/%m/%d\') birthday,
	t1.phone_number1,
	t1.phone_number2,
	t1.record_locator,
	t1.firstname_2,
	t1.lastname_2,
	t1.title_rcd_2,
	DATE_FORMAT(t1.birthday_2,\'%Y/%m/%d\') birthday_2,
	t1.phone_number1_2,
	t1.phone_number2_2,
	t1.record_locator_2,
	CASE WHEN (t1.firstname_2 IS NOT NULL OR t1.lastname_2 IS NOT NULL OR t1.title_rcd_2 IS NOT NULL OR t1.birthday_2 IS NOT NULL OR t1.phone_number1_2 IS NOT NULL OR t1.phone_number2_2 IS NOT NULL) THEN 1 ELSE 0 END pax_info_2_flg,
	t1.firstname_3,
	t1.lastname_3,
	t1.title_rcd_3,
	DATE_FORMAT(t1.birthday_3,\'%Y/%m/%d\') birthday_3,
	t1.phone_number1_3,
	t1.phone_number2_3,
	t1.record_locator_3,
	CASE WHEN (t1.firstname_3 IS NOT NULL OR t1.lastname_3 IS NOT NULL OR t1.title_rcd_3 IS NOT NULL OR t1.birthday_3 IS NOT NULL OR t1.phone_number1_3 IS NOT NULL OR t1.phone_number2_3 IS NOT NULL) THEN 1 ELSE 0 END pax_info_3_flg,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Phoenix class\' AND code2 = t1.phoenix_class LIMIT 1) phoenix_class,
	t1.phoenix_memo,
	t1.free_comment,
	t1.delete_flag,
	t1.create_user_id,
	DATE_FORMAT(t1.create_timestamp,\'%Y/%m/%d %H:%i:%S\') create_timestamp,
	t1.update_user_id,
	DATE_FORMAT(t1.update_timestamp,\'%Y/%m/%d %H:%i:%S\') update_timestamp,
	t2.station,
	t2.department,
	t2.position,
	DATE_FORMAT(t2.departure_date, "%Y/%m/%d") departure_date,
	t2.flight_number,
	t2.ship_no,
	t2.origin_rcd,
	t2.destination_rcd,
	t2.gate_spot,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Weather\' AND code2 = t2.weather LIMIT 1) weather,
	t2.std,
	t2.sta,
	t2.etd,
	t2.eta,
	t2.atd,
	t2.ata,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'DLA Code\' AND code2 = t2.dla_code LIMIT 1) dla_code,
	t2.dla_time,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'DLA Code\' AND code2 = t2.dla_code_2 LIMIT 1) dla_code_2,
	t2.dla_time_2,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'DLA Code\' AND code2 = t2.dla_code_3 LIMIT 1) dla_code_3,
	t2.dla_time_3,
	t2.dla_ttl,
	t2.pax_in,
	t2.pax_out,
	DATE_FORMAT(t2.reporting_date, "%Y/%m/%d") reporting_date,
	t2.day_of_week,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Area\' AND code2 = t2.area LIMIT 1) area,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Category\' AND code2 = t2.category LIMIT 1) category,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Factor\' AND code2 = t2.factor LIMIT 1) factor,
	t2.measures_to_revent_recurrence,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Influence on Safety\' AND code2 = t2.influence_on_safety LIMIT 1) influence_on_safety,
	(SELECT value2 FROM mst_system_code WHERE code1 = \'Frequency\' AND code2 = t2.frequency LIMIT 1) frequency,
	t2.approve_comment,
	t2.assessment,
	t2.staff_comment,
	\'\' category_name
FROM report_basic_info t1
INNER JOIN report_info_peregrine t2 ON t1.report_no = t2.report_no
LEFT JOIN report_basic_info t3 ON t1.related_report_no = t3.report_no AND t3.delete_flag <> ?
LEFT JOIN report_basic_info t4 ON t1.related_report_no_2 = t4.report_no AND t4.delete_flag <> ?
LEFT OUTER JOIN mst_system_code t5 ON t5.code1 = "Report Status" AND t1.report_status = t5.code2
WHERE t1.report_no = ? AND t1.delete_flag <> ?',
];