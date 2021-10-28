<div class="modal fade" id="Request_Parts" style="overflow-y: auto !important;" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Request Parts</h4>
				<button type="button" id="request_x_modal" class="close" onclick="request_x_modal_func()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden" class="form-control text-center">
				<div class="md-form mb-0 col-sm-7">
					<input type="text" id="kanban_scan" class="form-control text-center" oncopy="return false" onpaste="return false" autofocus>
					<label for="kanban_scan" id="kanban_scan_label" class="ml-3">Scan Kanban:</label>
					<input type="hidden" id="scanned_kanban">
					<input type="hidden" id="id_scanned_kanban">
				</div>
				<div class="text-center mb-0 mt-5 col-sm-5">
					<label class="h6 text-center text-danger" id="error_kanban"></label>
				</div>
				<div class="col-sm-12">
					<label id="save_output" class="d-flex justify-content-center"></label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6 text-muted"><i class="fas fa-qrcode"></i> Scanned Kanban <span id="kanban_scanned_count"></span></label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th><strong>No</strong></th>
								<th><strong>Line No</strong></th>
								<th><strong>Parts Code</strong></th>
								<th><strong>Parts Name</strong></th>
								<th><strong>Comment</strong></th>
								<th><strong>Length(mm)</strong></th>
								<th><strong>Quantity</strong></th>
								<th><strong>Action</strong></th>
							</tr>
						</thead>
						<tbody id="scanned_kanban_section">
							
						</tbody>
					</table>
				</div>
				<div class="col-sm-12">
					<label id="id_scanned_kanban_modal" class="float-right"></label>
				</div>
				<div class="md-form mb-0 col-sm-5" id="id_confirmation_section" style="display:none;">
					<input type="password" id="id_scan_employee" class="form-control text-center" oncopy="return false" onpaste="return false">
					<label for="id_scan_employee" id="id_scan_employee_label" class="ml-3">Please Scan your ID:</label>
				</div>
				<div class="text-center col-sm-12 col-md-12 col-lg-12">
					<label class="h5 text-center text-danger" id="confirmation_output"> </label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-info" onclick="save_request_parts()" id="btn_save_request" disabled> Request <i class="fas fa-paper-plane ml-1"></i></button>
			</div>
		</div>
	</div>
</div>