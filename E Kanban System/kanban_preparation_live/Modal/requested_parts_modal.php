<div class="modal fade" id="Requested_Parts" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false' style='overflow:scroll;'>
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
				<input type="hidden" id="open_details_mm_status" value='Close'>
				<div class="col-sm-12 col-md-12 col-lg-12" id="update_ready_for_delivery_section" style="display:none;">
					<div class="md-form mb-0 col-sm-5" style="display:none;">
						<input type="text" id="kanban_scan_ready_delivery" class="form-control text-center" autofocus>
						<label for="kanban_scan_ready_delivery" id="kanban_scan_ready_delivery_label" class="ml-3">Scan Kanban for Delivery:</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-left">
					<label class="h5" id="requestor_name_section"> Requestor Name: </label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-left">
					<label class="h6" id="requested_id_section"> Request ID: </label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-left">
					<label class="h6" id="status_head_section"> Status: </label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12" id='tracking_section'>
					<div class="track mt-3" id='tracked_pending' style='display:none;'>
						<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
						<div class="step"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Printed by MM</span> </div>
						<div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Store Out </span> </div>
						<!-- <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div> -->
					</div>
					<div class="track mt-3" id='tracked_ongoing' style='display:none;'>
						<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
						<div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Printed by MM</span> </div>
						<div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Store Out </span> </div>
						<!-- <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div> -->
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12" id="content_section_for_kanban">
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
								<th>Truck No</th>
								<th>Scanned Time</th>
								<th>Request Time</th>
								<th>Print Time</th>
								<th>Remarks</th>
							</tr>
						</thead>
						<tbody id="scanned_kanban_section_mm">
						</tbody>
					</table>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12" id="user_id_section" style="display:none;">
					<div class="md-form mb-0 col-sm-5">
						<input type="text" id="user_id" class="form-control text-center">
						<label for="user_id" id="user_id_label" class="ml-3">Please Scan your ID:</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_delivery"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<div class="md-form mb-0 mt-0 col-sm-2">
					<select class="browser-default custom-select" id="select_print_category">
					  <option selected>Please Select</option>
					</select>
				</div>
				<button class="btn unique-color text-white" onclick="confirm_id()" id="confirm_id_button" style="display:none;"> Confirm ID <i class="fas fa-user-check"></i></button>
				<button class="btn unique-color text-white" onclick="print_this()" id="print_this_button"> Print <i class="fas fa-print"></i></button>
			</div>
		</div>
	</div>
</div>