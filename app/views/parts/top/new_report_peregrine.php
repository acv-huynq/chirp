<div class="row">
	<div class="col-md-4 text-left ">
					<div class="row">
						<div class="col-md-1 pull-left">
							<span style="background-color: #CE019E;font-size:150%">&nbsp;</span>
						</div>
						<div class="col-md-10 text-left">
							<span style="font-size:150%"><strong>PEREGRINE_Irregularity</strong></span>
						</div>
					</div>
				</div>
</div>

			<div class="row row-margin-bottom-80">
				<div class="col-md-12">
					<table id="newReportTable" class="table table-bordered table-hover" border="1" cellpadding="2"  bordercolor="#000000">
						<thead>
							<tr class="gray">
								<th>Report Status</th>
								<th>Report No</th>
								<th>Report Title</th>
								<th>Station</th>
								<th>Reported By</th>
								<th>Reporting Date</th>
								<th>Flight No</th>
								<th>Modified</th>
								<th>Inquiry Status</th>
								<th>Preview</th>
							</tr>
						</thead>

						<tbody>
						<?php foreach($new_report_list['Irregularity'] as $data) { ?>
						<tr>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->report_status_name) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->report_no) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->report_title) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->station) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->reported_by) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->reporting_date) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->flight_number) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->update_timestamp) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->inquiry_status) ?></td>
								<td><button type="button" class="btn btn-lgray center-block btn-xs" onclick="selectPreview(document.forms.mainForm, '/p/chirp/top/preview', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><span id="PreviewIcon" class="glyphicon glyphicon-zoom-in"></span></button></td>
							</tr>
							<?php } ?>

						</tbody>
					</table>
				</div>
				<div class="col-md-12"><h3></h3></div>
				<div class="col-md-12">
					<div class="form-group">
						<button type="button" class="btn btn-pink" onclick="addReport(document.forms.mainForm, '/p/chirp/top/add', <?= HTML::entities($button_list[0]['code']) ?>)"><?= HTML::entities($button_list[0]['value']) ?></button>
					</div>
				</div>
			</div>


<div class="row">
	<div class="col-md-4 text-left ">
					<div class="row">
						<div class="col-md-1 pull-left">
							<span style="background-color: #CE019E;font-size:150%">&nbsp;</span>
						</div>
						<div class="col-md-10 text-left">
							<span style="font-size:150%"><strong>PEREGRINE_Incident</strong></span>
						</div>
					</div>
				</div>
</div>

			<div class="row row-margin-bottom-80">
				<div class="col-md-12">
					<table id="newReportTable2" class="table table-bordered table-hover" border="1" cellpadding="2"  bordercolor="#000000">
						<thead>
							<tr class="gray">
								<th>Report Status</th>
								<th>Report No</th>
								<th>Report Title</th>
								<th>Station</th>
								<th>Reported By</th>
								<th>Reporting Date</th>
								<th>Flight No</th>
								<th>Modified</th>
								<th>Inquiry Status</th>
								<th>Preview</th>
							</tr>
						</thead>

						<tbody>
						<?php foreach($new_report_list['Incident'] as $data) { ?>
						<tr>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->report_status_name) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->report_no) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->report_title) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->station) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->reported_by) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->reporting_date) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->flight_number) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->update_timestamp) ?></td>
								<td onclick="selectReport(document.forms.mainForm, '/p/chirp/top/select', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><?= HTML::entities($data->inquiry_status) ?></td>
								<td><button type="button" class="btn btn-lgray center-block btn-xs" onclick="selectPreview(document.forms.mainForm, '/p/chirp/top/preview', '<?= HTML::entities($data->report_class) ?>', '<?= HTML::entities($data->report_no) ?>')"><span id="PreviewIcon" class="glyphicon glyphicon-zoom-in"></span></button></td>
							</tr>
							<?php } ?>

						</tbody>
					</table>
				</div>
				<div class="col-md-12"><h3></h3></div>
				<div class="col-md-12">
					<div class="form-group">
						<button type="button" class="btn btn-pink" onclick="addReport(document.forms.mainForm, '/p/chirp/top/add', <?= HTML::entities($button_list[1]['code']) ?>)"><?= HTML::entities($button_list[1]['value']) ?></button>
					</div>
				</div>
			</div>
