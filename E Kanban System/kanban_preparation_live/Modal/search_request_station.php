<div class="modal fade" id="Search_Modal_Form_Station" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false' style='overflow:scroll;'>
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="stock_address_modal_head">Search Parts</h4>
				<button type="button" class="close" aria-label="Close" onclick="close_search_distributor()">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="search_distributor_status" value='Close'>
				<div class="row col-sm-12 col-md-12 col-lg-12">
					<div class="md-form mb-0 col-sm-4">
						<input type="datetime-local" id="date_from" class="form-control text-center">
						<label class="ml-3" for="date_from" id="date_from_Label">Date From:</label>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<input type="datetime-local" id="date_to" class="form-control text-center">
						<label class="ml-3" for="date_to" id="date_to_Label">Date To:</label>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<select class="browser-default custom-select form-control" id="search_status" onchange="status_change()">
							<option selected>Pending</option>
							<option>Ongoing Picking</option>
						</select>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<input type="text" id="line_no_search" class="form-control text-center">
						<label for="line_no_search" id="line_no_search_label" class="ml-3">Line No:</label>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<input type="text" id="parts_code_search1" class="form-control text-center">
						<label for="parts_code_search1" id="parts_code_search_label" class="ml-3">Parts Code:</label>
					</div>
					<div class="md-form mb-0 col-sm-4">
						<input type="text" id="parts_name_search1" class="form-control text-center">
						<label for="parts_name_search1" id="parts_name_search_label" class="ml-3">Parts Name:</label>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 mt-1" id='tracking_section_search'>
						<div class="track mt-3" id='tracked_pending_search' style='display:none;'>
							<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
							<div class="step"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Printed by MM</span> </div>
							<div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Store Out </span> </div>
							<!-- <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div> -->
						</div>
						<div class="track mt-3" id='tracked_op_search' style='display:none;'>
							<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
							<div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Printed by MM</span> </div>
							<div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Store Out </span> </div>
							<!-- <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div> -->
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 mx-0 my-0 px-0 py-0">
						<button class="btn unique-color white-text waves-effect float-right" onclick="export_excel()" data-toggle="tooltip" data-placement="top" title="Export All"><i class="fas fa-file-download"></i> Excel</button>
					</div>
				</div>
				<div class="row col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered">
						<thead class="unique-color text-white">
							<tr>
								<th><strong>No</strong></th>
								<th><strong>Line No</strong></th>
								<th><strong>Stock Address</strong></th>
								<th><strong>Parts Code</strong></th>
								<th><strong>Parts Name</strong></th>
								<th><strong>Kanban No</strong></th>
								<th><strong>Quantity</strong></th>
								<th><strong>Station</strong></th>
								<th><strong>Truck No.</strong></th>
								<th><strong>Scan Date & Time</strong></th>
								<th><strong>Request Date & Time</strong></th>
								<th><strong>Print Date & Time</strong></th>
								<th><strong>Remarks</strong></th>
								<th><strong>Status</strong></th>
							</tr>
						</thead>
						<tbody id="search_result_all">
							 
						</tbody>
					</table>
					<br>
					<input type="hidden" id="limiter_search" value="0">
					<input type="hidden" id="all_data_search">
					<div class="col-sm-12 col-md-12 col-lg-12 text-center">
						<div class="loader_popup text-center" id="loading_indicator_search" style="display:none;">Loading....</div>
					</div>
					<div class="my-0 mx-0 col-sm-12 col-md-12 col-lg-12">
						<label class="col-sm-12 col-md-12 col-lg-12 text-right" id="counter_viewer"></label>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 text-rigth" id="export_excel_showed" style="display:none;">
						<button class="btn unique-color white-text waves-effect float-right" onclick="export_excel_showed()" data-toggle="tooltip" data-placement="top" title="Export Results"><i class="fas fa-file-download"></i> Excel</button>
					</div>
					<div class="rounded-circle unique-color text-white card-img-100 mx-auto mb-1 pulse" id="see_more_search" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="see_more_search()" data-toggle="tooltip" data-placement="right" title="See More">
						<i class="text-white fas fa-redo" style="margin-left:17px;margin-top:17px;"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>