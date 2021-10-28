<div class="modal fade" id="Truck_Form" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="truck_head">Truck No</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden">
				<div class="row col-sm-12 col-md-12 col-lg-12" id="name_of_station_section">
					<div class="md-form mb-0 col-sm-12 col-md-12 col-lg-12">
						<input type="number" id="truck_no" class="form-control text-center" min ='0'>
						<label for="truck_no" id="truck_no_label" class="ml-3">Truck No.:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="time" id="time_from" class="form-control text-center">
						<label for="time_from" id="time_from_label" class="ml-3">From:</label>
					</div>
                    <div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="time" id="time_to" class="form-control text-center">
						<label for="time_to" id="time_to_label" class="ml-3">To:</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_truck"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text" onclick="save_truck()" id="save_truck_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn unique-color white-text" onclick="update_truck()" id="update_truck_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn unique-color white-text" onclick="delete_truck()" id="delete_truck_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>