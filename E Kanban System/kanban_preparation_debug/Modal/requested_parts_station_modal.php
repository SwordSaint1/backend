<div class="modal fade" id="Requested_Parts" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop='static' data-keyboard='false' style='overflow:scroll;'>
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Requested Parts</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="open_details_distributor_status" value='Close'>
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
						<thead class="unique-color text-white">
							<tr>
								<th>Line No</th>
								<th>Stock Address</th>
								<th>Parts Code</th>
								<th>Parts Name</th>
								<th>Quantity</th>
								<th>kanban No</th>
								<th>Truck No.</th>
								<th>Scanned Time</th>
								<th>Request Time</th>
								<th>Printing Time</th>
								<th>Remarks</th>
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