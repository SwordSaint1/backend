<div class="modal fade" id="Scooter_Station_Form" style="overflow-y: auto !important;" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold grey-text" id="scooter_station_modal_head">Add Scooter Station</h4>
				<button type="button" class="close" onclick="close_modal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<input type="hidden" id="id_hidden">
				<div class="row col-sm-12 col-md-12 col-lg-12" id="name_of_station_section">
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="name_of_station" class="form-control text-center" value="Name Of Station">
						<label for="name_of_station" id="name_of_station_label" class="ml-3">Name Of Station:</label>
					</div>
					<div class="md-form mb-0 col-sm-6 col-md-6 col-lg-6">
						<input type="text" id="ip" class="form-control text-center" value="Ip Address">
						<label for="ip" id="ip_label" class="ml-3">Ip Address:</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center">
					<label class="h6" id="out_statition"></label>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<button class="btn unique-color white-text" onclick="save_station()" id="save_station_button"> Save <i class="fas fa-check"></i></button>
				<button class="btn unique-color white-text" onclick="update_station()" id="update_station_button" style="display:none;"> Update <i class="far fa-edit"></i></i></button>
				<button class="btn unique-color white-text" onclick="delete_station()" id="delete_station_button" style="display:none;"> Delete <i class="fas fa-trash"></i></button>
			</div>
		</div>
	</div>
</div>