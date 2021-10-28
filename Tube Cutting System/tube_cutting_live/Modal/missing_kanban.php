<div class="modal fade" id="Missing_Kanban_History" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">History</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" name="hidden_kanban" id="hidden_kanban">
				<input type="hidden" name="hidden_serial" id="hidden_serial">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<button class="btn btn-info float-right" onclick="print_missing()" data-toggle="tooltip" data-placement="top" title="Print Kanban"><i class="fas fa-print"></i> Print</button>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12" id="content_section_for_kanban_missing">
					<table class="table table-bordered table-sm">
						<thead class="blue-grey lighten-4">
							<tr>
								<th class="h6">No</th>
								<th class="h6">Line No</th>
								<th class="h6">Stock Address</th>
								<th class="h6">Parts Code</th>
								<th class="h6">Parts Name</th>
								<th class="h6">Comment</th>
								<th class="h6">Length(mm)</th>
								<th class="h6">Quantity</th>
								<th class="h6">Kanban No</th>
								<th class="h6">Scan Date</th>
								<th class="h6">Request Date</th>
								<th class="h6">Print Date</th>
								<th class="h6">Storeout Date</th>
							</tr>
						</thead>
						<tbody id="missing_history_section">
						</tbody>
					</table>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-2 mb-2 pt-0 pb-0">
					<div class="loader_popup text-info text-center" id="loader_indicator_history" style="display:none;">Loading....</div>
				</div>
			</div>
		</div>
	</div>
</div>