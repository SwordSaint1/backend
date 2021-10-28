<div class="modal fade" id="Open_Reprint_History" aria-labelledby="myModalLabel" data-backdrop='static' data-keyboard='false' style='overflow:scroll;'>
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Reprint History</h4>
				<button type="button" class="close" onclick="close_modal_reprint_history()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="col-sm-12 col-md-12 col-lg-12" id="content_section_for_reprint_history">
					<table class="table table-bordered table-sm">
						<thead class="unique-color white-text">
							<tr>
								<th>No</th>
								<th>Line No</th>
								<th>Stock Address</th>
								<th>Parts Code</th>
								<th>Parts Name</th>
								<th>Quantity</th>
								<th>Kanban No</th>
								<th>Scanned Time</th>
								<th>Request Time</th>
								<th>Reprint Time</th>
							</tr>
						</thead>
						<tbody id="reprint_history_section">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
			</div>
		</div>
	</div>
</div>