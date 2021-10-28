<div class="modal fade" id="Requested_Parts" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Requested Parts</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_scanned_kanban_selected">
				<div class="col-sm-12 col-md-12 col-lg-12" id="update_ready_for_delivery_section" style="display:none;">
					<div class="md-form mb-0 col-sm-5">
						<input type="text" id="kanban_scan_ready_delivery" class="form-control text-center" autofocus>
						<label for="kanban_scan_ready_delivery" id="kanban_scan_ready_delivery_label" class="ml-3">Scan Kanban for Delivery:</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-left">
					<label class="h5" id="requestor_name_section"> Requestor Name: </label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12" id="content_section_for_kanban">
					<table class="table table-bordered table-sm">
						<thead class="blue-grey lighten-4">
							<tr>
								<th>Line No</th>
								<th>Stock Address</th>
								<th>Parts Code</th>
								<th>Parts Name</th>
								<th>Quantity</th>
								<th>KBN No</th>
								<th>Time Scanned</th>
								<th>Receiving Time</th>
								<th>Store Out</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="scanned_kanban_section_station">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>