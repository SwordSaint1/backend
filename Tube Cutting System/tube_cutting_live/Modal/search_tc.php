<div class="modal fade" id="Search_Modal_Form_admin" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="stock_address_modal_head">Search Parts</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
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
					<div class="md-form mb-0 col-sm-3">
						<input type="text" id="line_no_search" class="form-control text-center">
						<label for="line_no_search" id="line_no_search_label" class="ml-3">Line No:</label>
					</div>
					<div class="md-form mb-0 col-sm-3">
						<input type="text" id="parts_code_search1" class="form-control text-center">
						<label for="parts_code_search1" id="parts_code_search_label" class="ml-3">Parts Code:</label>
					</div>
					<div class="md-form mb-0 col-sm-3">
						<input type="text" id="parts_name_search1" class="form-control text-center">
						<label for="parts_name_search1" id="parts_name_search_label" class="ml-3">Parts Name:</label>
					</div>
					<div class="md-form mb-0 col-sm-3">
						<input type="text" id="comment_search1" class="form-control text-center">
						<label for="comment_search1" id="comment_search_label" class="ml-3">Comment:</label>
					</div>
					<div class="md-form mb-0 col-sm-3">
						<input type="text" id="length_search1" class="form-control text-center">
						<label for="parts_name_search1" id="length_search_label" class="ml-3">Length:</label>
					</div>
				</div>
				<div class="row col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-sm">
						<thead class="blue-grey lighten-3">
							<tr>
								<th><strong>No</strong></th>
								<th><strong>Line No</strong></th>
								<th><strong>Stock Address</strong></th>
								<th><strong>Parts Code</strong></th>
								<th><strong>Parts Name</strong></th>
								<th><strong>Comment</strong></th>
								<th><strong>Length(mm)</strong></th>
								<th><strong>Quantity</strong></th>
								<th><strong>Scan Date & Time</strong></th>
								<th><strong>Request Date & Time</strong></th>
								<th><strong>Print Date & Time</strong></th>
								<th><strong>TC Remarks</strong></th>
								<th><strong>Distributor Remarks</strong></th>
								<th><strong>Status</strong></th>
								<th><strong>Print</strong></th>
							</tr>
						</thead>
						<tbody id="search_result_all">
							
						</tbody>
					</table>
				</div>
				<input type="hidden" id="limiter_search">
				<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-0 mb-0 pt-0 pb-0">
					<div class="loader_popup text-info text-center" id="loading_indicator_search" style="display:none;">Loading....</div>
				</div>
				<div class="row mx-0 col-sm-12 col-md-12 col-lg-12">
					<input type="hidden" id="load_more_counter" value="0"> <!--  Loadmore Limiter Count  -->
					<div class="rounded-circle info-color card-img-100 mx-auto mb-1 pulse" id="load_more_botton" style="margin-top:-10px;width:50px;height:50px;cursor:pointer;display:none;" onclick="see_more_search()" data-toggle="tooltip" data-placement="top" title="Load More">
						<i class="text-white fas fa-redo" style="margin-left:17px;margin-top:17px;"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>