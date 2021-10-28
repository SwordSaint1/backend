<div class="modal fade" id="Route_Form" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="route_head">Route No</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden">
				<div class="row col-sm-12 col-md-12 col-lg-12" id="name_of_station_section">
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="number" id="route_no" class="form-control text-center" min ='0'>
						<label for="route_no" id="route_no_label" class="ml-3">Route No.:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="car_maker" class="form-control text-center">
						<label for="car_maker" id="car_maker_label" class="ml-3">Car Maker:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<select id="scooter_station" class="browser-default form-control">
							<option selected>Scooter Station</option>
						</select>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_route"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text" onclick="save_route()" id="save_route_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn unique-color white-text" onclick="update_route()" id="update_route_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn unique-color white-text" onclick="delete_route()" id="delete_route_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>