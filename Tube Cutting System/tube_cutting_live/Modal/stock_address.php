<div class="modal fade" id="Stock_Address_Form" aria-labelledby="myModalLabel" aria-hidden="true" style='overflow:scroll;'>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="stock_address_modal_head">Add Stock Address</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden">
				<div class="row col-sm-12 col-md-12 col-lg-12" id="name_of_station_section">
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="stock_address" class="form-control text-center" value="Stock Address">
						<label for="stock_address" id="stock_address_label" class="ml-3">Stock Address:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="parts_code" class="form-control text-center" value="Parts Code">
						<label for="parts_code" id="parts_code_label" class="ml-3">Parts Code:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="parts_name" class="form-control text-center" value="Parts Name">
						<label for="parts_name" id="parts_name_label" class="ml-3">Parts Name:</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_stock_address"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn btn-info" onclick="save_stock_address()" id="save_stock_address_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn btn-info" onclick="update_stock_address()" id="update_stock_address_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn btn-info" onclick="delete_stock_address()" id="delete_stock_address_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>