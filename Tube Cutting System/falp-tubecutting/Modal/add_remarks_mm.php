<div class="modal fade" id="Add_Remarks_Form" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Add Remarks</h4>
				<button type="button" class="close" onclick="close_modal_remarks()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="remarks_id_scanned_kanban">
				<input type="hidden" id="remarks_kanban">
				<input type="hidden" id="remarks_kanban_num">
				<input type="hidden" id="remarks_scan_date_time">
				<input type="hidden" id="remarks_request_date_time">
				<input type="hidden" id="remarks_scooter_station">
				<div class="row col-sm-12 col-md-12 col-lg-12 mx-0">
					<div class="md-form mb-0 col-sm-12 col-md-12 col-lg-12 mx-0">
						<textarea id="mm_remarks" class="md-textarea form-control" rows="3"></textarea>
						<label for="mm_remarks" id="mm_remarks_Label" class="ml-3">Remarks</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_mm_remarks"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-info" onclick="save_mm_remarks()" id="save_mm_remarks_button"> Save <i class="fas fa-check"></i></button>
			</div>
		</div>
	</div>
</div>