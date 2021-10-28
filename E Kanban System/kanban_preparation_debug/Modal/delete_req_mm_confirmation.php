<div class="modal fade" id="Confirm_Id_To_Delete_MM" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h5 class="modal-title w-100 font-weight-bold grey-text">Delete Kanban</h5>
				<button type="button" id="cancel_delete" class="close" onclick="cancel_delete()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
			<div class="text-center col-sm-12">
				<label class="text-danger">Please Comfirm your Password to Delete This Request!</label>
			</div>
				<input type="hidden" id="kanban_req_to_delete_mm" class="form-control text-center">
				<div class="md-form mb-0 col-sm-12" id="confirm_to_delete_mm_div">
					<input type="password" id="confirm_to_delete_mm" class="form-control text-center">
					<label for="confirm_to_delete_mm" id="confirm_to_delete_label" class="ml-3">Please Enter Password:</label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<label class="text-danger h6" id="deletation_confirmed_mm"></label>
			</div>
		</div>
	</div>
</div>