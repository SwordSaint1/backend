<div class="modal fade" id="Add_Remarks_Form_Search" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 1100 !important;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Add Remarks</h4>
				<button type="button" class="close" onclick="close_modal_remarks_search()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="remarks_id_scanned_kanban_search">
				<input type="hidden" id="remarks_kanban_search">
				<input type="hidden" id="remarks_kanban_num_search">
				<input type="hidden" id="remarks_scan_date_time_search">
				<input type="hidden" id="remarks_request_date_time_search">
				<input type="hidden" id="remarks_scooter_station_search">
				<div class="row col-sm-12 col-md-12 col-lg-12 mx-0">
					<div class="md-form mb-0 col-sm-12 col-md-12 col-lg-12 mx-0">
						<textarea id="mm_remarks_search" class="md-textarea form-control" rows="3"></textarea>
						<label for="mm_remarks_search" id="mm_remarks_search_Label" class="ml-3">Remarks</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_tc_remarks_search"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-default" onclick="save_tc_remarks_search()" id="save_tc_remarks_button"> Save <i class="fas fa-check"></i></button>
			</div>
		</div>
	</div>
</div>