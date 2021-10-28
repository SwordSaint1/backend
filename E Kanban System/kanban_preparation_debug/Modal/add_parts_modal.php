<div class="modal fade" id="mm_add_parts" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fluid">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="accounts_head">Add New Item</h4>
				<button type="button" class="close" onclick="close_modal_add()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<!-- FORM -->
				<div class="row col-sm-12 ">
					<!-- KANBAN QR CODE -->
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="name" class="form-control text-center" value="">
						<label for="name" id="name_label" class="ml-3">KANBAN QRCODE</label>
					</div>
				</div>

				<!-- </FORM> -->
				
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text" onclick="save_accounts()" id="save_accounts_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn unique-color white-text" onclick="update_accounts()" id="update_accounts_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn unique-color white-text" onclick="delete_accounts()" id="delete_accounts_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>