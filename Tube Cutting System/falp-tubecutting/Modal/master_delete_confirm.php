<div class="modal fade" id="Master_Delete_Confirm" aria-labelledby="myModalLabel" aria-hidden="true" style='z-index: 1100 !important;overflow:scroll;'>
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
                    <label class="text-danger">Are you sure you want to delete this kanban?</label>
                    <label class="text-danger h6" id="deletation_confirmed_mm"></label>
                </div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="output_data_delete"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<input type="hidden" id="idForDeleteHidden">
                <button class="btn btn-danger mx-0 my-0" onclick="master_delete_confirmed()"><i class="fas fa-trash"></i> Yes. Delete it</button>
                <button class="btn btn-info mx-0 my-0" onclick="master_delete_cancel()"><i class="fas fa-times"></i> No. Cancel</button>
			</div>
		</div>
	</div>
</div>