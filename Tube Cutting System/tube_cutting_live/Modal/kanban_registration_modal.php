<div class="modal fade" id="Kanban_Registration_Form" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 1100 !important;" style='overflow:scroll;'>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text">Register Kanban</h4>
				<button type="button" id="close_reg" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="hidden_id_kanban">
				<div class="md-form mb-0 col-sm-6">
					<input type="number" id="production_lot" class="form-control text-center">
					<label for="production_lot" id="production_lot_label" class="ml-3">Production Lot:</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="parts_code" class="form-control text-center">
					<label for="parts_code" id="parts_code_label" class="ml-3">Parts Code:</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="line_no" class="form-control text-center">
					<label for="line_no" id="line_no_label" class="ml-3">Line No:</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="stock_address" class="form-control text-center">
					<label for="stock_address" id="stock_address_label" class="ml-3">Stock Address:</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="parts_name" class="form-control text-center">
					<label for="parts_name" id="parts_name_label" class="ml-3">Parts Name:</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="comment" class="form-control text-center">
					<label for="comment" id="comment_label" class="ml-3">Comment:</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="length" class="form-control text-center">
					<label for="length" id="length_label" class="ml-3">Length(mm):</label>
				</div>
				<div class="md-form mb-0 col-sm-6">
					<input type="text" id="quantity" class="form-control text-center">
					<label for="quantity" id="quantity_label" class="ml-3">Quantity:</label>
				</div>
				<div class="md-form mb-0 col-sm-6" id="required_knb_section">
					<input type="number" id="required_knb" class="form-control text-center">
					<label for="required_knb" id="required_knb_label" class="ml-3">Required Kanban:</label>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="output_data"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-info" onclick="save_kanban()" id="btn_save_kanban"> Save <i class="fas fa-paper-plane ml-1"></i></button>
				<button class="btn btn-info" onclick="update_kanban()" id="btn_update_kanban" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn btn-info" onclick="delete_kanban()" id="btn_delete_kanban" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>