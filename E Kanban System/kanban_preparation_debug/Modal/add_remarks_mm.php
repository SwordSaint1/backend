<div class="modal fade" id="Add_Remarks_Form" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false' style='z-index:2000;'>
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Remarks</h4>
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
				<input type="hidden" id="remarks_status">
				<input type="hidden" id="active_conversation" value="Close">
				<input type="hidden" id="conversation_count">
				<!-- Start of Conversation -->
				<div class="container">
					<div class="row d-flex flex-row-reverse">
						<div class="col-sm-12 col-md-12 col-lg-12 mx-0 my-0 px-0 py-0 mb-4 d-flex flex-row-reverse">
							<div class="chat-room small-chat wide col-md-12 col-lg-12 mx-0 my-0 px-0 py-0" id="myForm">
								<div class="my-custom-scrollbar col-md-12 col-lg-12 mx-0 my-0 px-0 py-0" id="message">
									<div class="card-body p-3 col-sm-12 col-md-12 col-lg-12 mx-0 my-0 px-0 py-0 mh-10" id="convo_remarks">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- End of Conversation -->
				<div class="col-sm-12 col-md-12 col-lg-12 mx-0 my-0 px-0 py-0">
					<div class="md-form col-sm-12 col-md-12 col-lg-12 mx-0 my-0">
						<textarea id="mm_remarks" class="md-textarea form-control" onchange='mm_remarks_change()'></textarea>
						<label for="mm_remarks" id="mm_remarks_Label" class="ml-3">Remarks</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 mx-0 my-0 d-flex justify-content-center">
					<button class="btn unique-color text-white" onclick="save_mm_remarks()" id="save_mm_remarks_button"> Save <i class="fas fa-check"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>